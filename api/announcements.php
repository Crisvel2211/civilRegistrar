<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include your database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    createAnnouncement();
} else {
    echo json_encode(['message' => 'Method not allowed']);
    http_response_code(405);
}

function createAnnouncement() {
    global $conn;

    // Check if POST fields are set
    if (isset($_POST['title'], $_POST['description'], $_POST['posted_by'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $postedBy = trim($_POST['posted_by']);

        // Check if fields are empty
        if (empty($title) || empty($description) || empty($postedBy)) {
            echo json_encode(['message' => 'All fields are required.']);
            http_response_code(400);
            return;
        }

        // Initialize image path
        $imagePath = null;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imagePath = uploadImage($_FILES['image']);
            if (is_string($imagePath)) {
                echo json_encode(['message' => $imagePath]); // Return the error message
                http_response_code(400);
                return;
            }
        }

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO announcements (title, description, posted_by, image_path) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['message' => 'Database statement preparation failed: ' . $conn->error]);
            http_response_code(500);
            return;
        }

        $stmt->bind_param("ssss", $title, $description, $postedBy, $imagePath);

        // Execute and check for errors
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Announcement created successfully']);
            http_response_code(201);
        } else {
            echo json_encode(['message' => 'Failed to create announcement: ' . $stmt->error]);
            http_response_code(500);
        }
        $stmt->close();
    } else {
        echo json_encode(['message' => 'Invalid input. Make sure all fields are filled.']);
        http_response_code(400);
    }
}

function uploadImage($file) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate if the uploaded file is an image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "File is not an image.";
    }

    // Allow specific file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        return "Invalid file format. Allowed formats are: " . implode(", ", $allowedFormats);
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading file: " . $file['error'];
    }

    // Move uploaded file to target directory
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile; // Return the path to the uploaded image
    } else {
        return "Failed to move uploaded file.";
    }
}
?>
