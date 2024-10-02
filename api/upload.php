<?php
require 'vendor/autoload.php'; // Include the Cloudinary PHP SDK

use Cloudinary\Cloudinary;

// Configure Cloudinary with your credentials
$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'YOUR_CLOUD_NAME',
        'api_key' => 'YOUR_API_KEY',
        'api_secret' => 'YOUR_API_SECRET',
    ]
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Handle image upload
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $filePath = $image['tmp_name'];

        try {
            // Upload the image to Cloudinary
            $uploadResult = $cloudinary->uploadApi()->upload($filePath, [
                'folder' => 'resident_profile' // Optional: Specify folder in Cloudinary
            ]);

            // Get the image URL from Cloudinary
            $imageUrl = $uploadResult['secure_url'];

            // Return the image URL in response
            echo json_encode([
                'status' => 'success',
                'imageUrl' => $imageUrl
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload failed: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'File upload error'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
}
?>
