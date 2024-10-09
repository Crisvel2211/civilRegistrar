<?php
header('Content-Type: application/json');
include 'db.php'; // Ensure this file includes the database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the document ID from the form input
    $API_KEY = 'AIzaSyCnpuKoIA96Y5WeTtGQAN-u0L_mcAx7XVU';
    
    $documentId = $_POST['document_id'] ?? null;

    if (is_null($documentId)) {
        echo json_encode(['success' => false, 'message' => 'Document ID is required.']);
        exit();
    }

    // Fetch user data from the verification_documents table
    $stmt = $conn->prepare("SELECT full_name, address, image FROM verification_documents WHERE id = ?");
    $stmt->bind_param("i", $documentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();

    // Check if document data was found
    if (!$document) {
        echo json_encode(['success' => false, 'message' => 'Document not found.']);
        exit();
    }

    // Get the details from the fetched document
    $fullName = $document['full_name'];
    $address = $document['address'];
    $storedImagePath = $document['image'];

    // If there's an uploaded image, handle it
    $uploadedImage = $_FILES['image'];

    // Initialize variable to hold file path
    $imageData = null;

    // Check for image upload errors
    if ($uploadedImage['error'] === UPLOAD_ERR_OK) {
        // Save the uploaded image
        $uploadDir = 'uploads/';
        $uploadedImagePath = $uploadDir . basename($uploadedImage['name']);

        if (!move_uploaded_file($uploadedImage['tmp_name'], $uploadedImagePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image uploaded or error in upload.']);
        exit();
    }

    // Compare the uploaded image with the stored image using hashing
    $storedImageHash = hash_file('md5', $storedImagePath);
    $uploadedImageHash = hash_file('md5', $uploadedImagePath);

    // Check if the hashes match
    if ($storedImageHash === $uploadedImageHash) {
        $verificationResult = "Verification successful for $fullName at $address";

        // Save the verification result into your database or process it as needed
        $stmt = $conn->prepare("INSERT INTO verification_results (document_id, result) VALUES (?, ?)");
        $stmt->bind_param("is", $documentId, $verificationResult);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => $verificationResult]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save verification result.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Verification failed: images do not match.']);
    }

    $stmt->close();
}
$conn->close();

?>
