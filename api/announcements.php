<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

// Define the base URL for the uploaded images
$base_url = 'http://localhost/civil-registrar/api/uploads/';

// Check the request method
if ($method == 'GET') {
    // Retrieve user role and user ID from the query parameters
    $role = $_GET['role'] ?? null;
    $userId = $_GET['userId'] ?? null;

    if ($role && $userId) {
        // Define the query based on the user's role
        if ($role === 'employee') {
            $sql = "SELECT * FROM announcements WHERE announcement_type = 'employee' OR announcement_type = 'all' ORDER BY created_at DESC";
        } elseif ($role === 'resident') {
            $sql = "SELECT * FROM announcements WHERE announcement_type = 'resident' OR announcement_type = 'all' ORDER BY created_at DESC";
        } else {
            echo json_encode(["error" => "Invalid role"]);
            exit;
        }

        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            $announcements = [];
            while ($row = $result->fetch_assoc()) {
                $announcements[] = $row;
            }
            echo json_encode($announcements);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Role or UserId is missing"]);
    }
}

if ($method == 'POST') {
    // Check if POST data is set
    $userId = $_POST['userId'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $announcement_type = $_POST['announcement_type'] ?? null;

    // Handle file uploads
    $image = $_FILES['image'] ?? null;
    $upload_dir = 'uploads/'; // Directory where files will be uploaded
    $file_path = '';

    // Check and create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Check for file upload errors
    if ($image) {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(["error" => "Error uploading file. Error Code: " . $image['error']]);
            exit;
        }

        $file_name = basename($image['name']);
        $target_file = $upload_dir . uniqid() . '_' . $file_name;

        // Validate file extension
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg', 'pdf']; // Added pdf

        if (!in_array($imageFileType, $allowed_extensions)) {
            echo json_encode(["error" => "Invalid file type. Only image and PDF files are allowed."]);
            exit;
        }

        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            $file_path = $target_file; // Store the file path
        } else {
            echo json_encode(["error" => "Failed to upload file: $file_name"]);
            exit;
        }
    } else {
        echo json_encode(["error" => "No file uploaded."]);
        exit;
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO announcements (userId, title, description, announcement_type, created_at, image) VALUES (?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $userId, $title, $description, $announcement_type, $file_path);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Announcement document created successfully."]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

?>
