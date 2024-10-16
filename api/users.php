<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection file

$method = $_SERVER['REQUEST_METHOD'];
// Define the base URL for the uploaded images
$base_url = 'http://localhost/civil-registrar/api/uploads/';

if ($method === 'GET') {
    // Check if the request includes an ID for a specific user
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT id, name, email, role FROM users WHERE id=$id";
        $result = $conn->query($sql);
        if ($result) {
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
    } else {
        // If no specific ID is requested, check if there's a search query or role filter
        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $role = isset($_GET['role']) ? $conn->real_escape_string($_GET['role']) : '';

        // Build the SQL query
        $sql = "SELECT * FROM users WHERE 1=1";

        if ($search) {
            $sql .= " AND name LIKE '%$search%'";
        }

        if ($role) {
            $sql .= " AND role = '$role'";
        }

        $result = $conn->query($sql);
        if ($result) {
            $users = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($users);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
    }
}


if ($method === 'POST') {
    // Create a new user
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $role = $conn->real_escape_string($data['role']);

    // Handle file uploads
    $image = $_FILES['image'] ?? null;
    $upload_dir = 'uploads/'; // Directory where files will be uploaded
    $file_path = ''; 

    // Check and create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Check for file upload
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($image['name']);
        $target_file = $upload_dir . uniqid() . '_' . $file_name;

        // Validate file extension
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg']; // Added pdf support

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // If the file is uploaded successfully, set the file path
                $file_path = $base_url . basename($target_file); // Store the full URL to the image
            } else {
                echo json_encode(["error" => "Failed to upload file: $file_name"]);
                exit;
            }
        } else {
            echo json_encode(["error" => "Invalid file type. Only image and PDF files are allowed."]);
            exit;
        }
    }

    // Insert user into the database with userProfile
    $sql = "INSERT INTO users (name, email, password, role, userProfile) VALUES ('$name', '$email', '$password', '$role', '$file_path')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'User created successfully']);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}


if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check if all required fields are set
    if (isset($data['id'], $data['name'], $data['email'], $data['role'])) {
        $id = intval($data['id']);
        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $role = $conn->real_escape_string($data['role']);
        $password = isset($data['password']) && !empty($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null;

        $userId = intval($_SERVER['HTTP_USERID'] ?? 0); // Use null coalescing operator for safety
        $userRole = $_SERVER['HTTP_USERROLE'] ?? ''; // Use null coalescing operator for safety

        // Check if the user is updating their own profile
        if ($id === $userId) {
            $sql = "UPDATE users SET name='$name', email='$email', role='$role'";
            if ($password) {
                $sql .= ", password='$password'";
            }
            $sql .= " WHERE id=$id";

            // Execute the update query
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Profile updated successfully']);
            } else {
                echo json_encode(['error' => $conn->error]);
            }
        } 
        // Else check if the user is an admin
        else if ($userRole === 'admin' ) {
            $sql = "UPDATE users SET name='$name', email='$email', role='$role'";
            if ($password) {
                $sql .= ", password='$password'";
            }
            $sql .= " WHERE id=$id";

            // Execute the update query
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'User updated successfully']);
            } else {
                echo json_encode(['error' => $conn->error]);
            }
        } 
        else {
            echo json_encode(['error' => 'Unauthorized: You do not have permission to update this user']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request: Missing required fields']);
    }
}

    


if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $id = intval($data['id']);
        
        // Prepare statement to avoid SQL injection
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            echo json_encode(['error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid request: Missing user ID']);
    }
}


?>
