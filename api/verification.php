<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

// Define the base URL for the uploaded images
$base_url = 'http://localhost/civil-registrar/api/uploads/'; 

// Handle GET requests to fetch all documents, by ID, or by userId
if ($method == 'GET') {
    // Check if an ID is provided to fetch a specific document
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Get the ID from the query parameters

        // Prepare SQL query to fetch a document by ID
        $sql = "SELECT * FROM verification_documents WHERE id = ?";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Bind the ID parameter
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['message' => 'No document found for the provided ID.']);
            exit; // Exit if no document found
        }

        $document = $result->fetch_assoc();
        // Prepend base URL to the image path
        $document['image'] = $base_url . basename($document['image']);
        
        echo json_encode($document); // Return the document as JSON

    } else {
        // If no ID is provided, proceed with the search
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        // Prepare the base SQL query for search
        $sql = "SELECT * FROM verification_documents WHERE 
                    user_id LIKE ? OR 
                    full_name LIKE ? OR 
                    verification_type LIKE ?";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Bind the search parameters
        $likeTerm = '%' . $conn->real_escape_string($searchTerm) . '%'; // Prevent SQL injection
        $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
        $documents = [];
        
        while ($row = $result->fetch_assoc()) {
            // Prepend base URL to the image path
            $row['image'] = $base_url . basename($row['image']);
            $documents[] = $row;
        }

        // Return the array of documents as JSON
        echo json_encode($documents);
    }
}


// Handle POST requests to create a new verification document
if ($method == 'POST') {
    // Check if POST data is set
    $user_id = $_POST['user_id'] ?? null;
    $full_name = $_POST['full_name'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $address = $_POST['address'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $verification_type = $_POST['verification_type'] ?? null;

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
    $sql = "INSERT INTO verification_documents (user_id, full_name, date_of_birth, address, phone, verification_type, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $full_name, $date_of_birth, $address, $phone, $verification_type, $file_path);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Verification document created successfully."]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
}


// Handle PUT requests to update an existing verification document
if ($method == 'PUT') {
    // Get the raw body from the request
    $input = json_decode(file_get_contents("php://input"), true);

    // Check if the keys exist in the input
    if (isset($input['id'], $input['user_id'], $input['full_name'], $input['date_of_birth'], $input['address'], $input['phone'], $input['verification_type'])) {
        // Extract data safely
        $id = intval($input['id']);
        $user_id = $input['user_id'];
        $full_name = $input['full_name'];
        $date_of_birth = $input['date_of_birth'];
        $address = $input['address'];
        $phone = $input['phone'];
        $verification_type = $input['verification_type'];

        // Prepare and execute the SQL statement
        $sql = "UPDATE verification_documents SET user_id = ?, full_name = ?, date_of_birth = ?, address = ?, phone = ?, verification_type = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssi", $user_id, $full_name, $date_of_birth, $address, $phone, $verification_type, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Verification document updated successfully."]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Required fields are missing."]);
    }
}

// Handle DELETE requests to delete a verification document
if ($method == 'DELETE') {
    // Check for ID in query parameters
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);
    $id = intval($query['id'] ?? 0); // Use null coalescing operator to default to 0 if not set

    if ($id > 0) {
        // Prepare statement to avoid SQL injection
        $sql = "DELETE FROM verification_documents WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(["message" => "Verification document deleted successfully."]);
            } else {
                echo json_encode(["error" => "No document found with the given ID."]);
            }
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Invalid ID provided."]);
    }
}
?>
