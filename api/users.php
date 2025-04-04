<?php

header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    http_response_code(200);
    exit();
}

include 'db.php'; // Include your database connection





$method = $_SERVER['REQUEST_METHOD'];
// Define the base URL for the uploaded images
$base_url = 'https://civilregistrar.lgu2.com/api/uploads/';

if ($method === 'GET') {
    // Check for count parameter
    if (isset($_GET['count']) && $_GET['count'] === 'true') {
        // Count total users
        $count_sql = "SELECT COUNT(*) AS total_users FROM users";
        $count_result = $conn->query($count_sql);
        $total_count = $count_result ? $count_result->fetch_assoc()['total_users'] : 0;

        echo json_encode(['total' => $total_count]);
        exit;
    }
    // Add check for roleCounts parameter
    if (isset($_GET['roleCounts']) && $_GET['roleCounts'] === 'true') {
        // Query to get count of users by role (Admin, Employee, Resident)
        $role_sql = "
            SELECT 
                SUM(CASE WHEN role = 'Admin' THEN 1 ELSE 0 END) AS admin_count,
                SUM(CASE WHEN role = 'Employee' THEN 1 ELSE 0 END) AS employee_count,
                SUM(CASE WHEN role = 'Resident' THEN 1 ELSE 0 END) AS resident_count
            FROM users";
        
        $role_result = $conn->query($role_sql);

        if ($role_result) {
            $counts = $role_result->fetch_assoc();
            echo json_encode([
                'admin' => $counts['admin_count'],
                'employee' => $counts['employee_count'],
                'resident' => $counts['resident_count']
            ]);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
        exit;
    }
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
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
        echo json_encode(['error' => 'Invalid input']);
        exit();
    }

    $name = trim($conn->real_escape_string($data['name']));
    $email = trim($conn->real_escape_string($data['email']));
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $role = trim($conn->real_escape_string($data['role']));

    $sql_check = "SELECT id FROM users WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if (!$result_check) {
        echo json_encode(['error' => 'Query error: ' . $conn->error]);
        exit();
    }

    if ($result_check->num_rows > 0) {
        echo json_encode(['error' => 'Email already exists']);
        exit();
    }

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(true); // No message, just a success response
    } else {
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }

    exit();
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