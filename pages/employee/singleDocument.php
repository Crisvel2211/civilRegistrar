<?php
// Include database connection
include '../../api/db.php'; // Adjust the path as needed

// Get the document ID from the URL
$documentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Prepare the SQL statement
$sql = "SELECT * FROM verification_documents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $documentId);
$stmt->execute();
$result = $stmt->get_result();

// Check if a document is found
if ($result->num_rows > 0) {
    // Fetch the document data
    $document = $result->fetch_assoc();
} else {
    // Document not found
    $document = null;
}

// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Prepare content for displaying the document
$singleDocumentContent = '';

if ($document) {
    $imageUrl = "http://localhost/group69/api/{$document['image']}"; // Use the image path directly

    $singleDocumentContent = "
        <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
            <h1 class='text-2xl font-bold mb-4'>{$document['full_name']} Verification </h1>
            <div class='grid grid-cols-1 md:grid-cols-2 place-items-center'>
                <div class='bg-green-300 p-2 rounded-sm'>
                    <img src='{$imageUrl}' alt='Verification Document' class='w-full h-64 fill rounded-md mb-4'>
                    <p class='text-gray-700'>User ID: <span class='font-medium'>{$document['user_id']}</span></p>
                    <p class='text-gray-700'>Date of Birth: <span class='font-medium'>{$document['date_of_birth']}</span></p>
                    <p class='text-gray-700'>Address: <span class='font-medium'>{$document['address']}</span></p>
                    <p class='text-gray-700'>Phone: <span class='font-medium'>{$document['phone']}</span></p>
                    <p class='text-gray-700'>Verification Type: <span class='font-medium'>{$document['verification_type']}</span></p>
                </div>
                <div>
                    <div class='w-full max-w-lg bg-white p-8 rounded-lg shadow-lg'>
                        <h1 class='text-2xl font-bold mb-4 text-center'>Verification</h1>
                        <form id='verify-form' enctype='multipart/form-data' class='space-y-6'>
                            <input type='hidden' name='document_id' value='{$documentId}'>
                            <div>
                                <label class='block text-sm font-medium text-gray-700'>Upload Image</label>
                                <div id='drop-area' class='mt-1 p-4 border border-gray-300 rounded-md bg-gray-50'>
                                    <p class='text-center text-gray-500'>Drag & drop an image here or click to select</p>
                                    <input type='file' name='image' id='image' accept='image/*' required class='hidden'>
                                </div>
                            </div>
                            <button type='submit' class='w-full bg-blue-600 text-white py-2 rounded-md'>Verify Identify</button>
                        </form>
                        <!-- Output area for verification result -->
                        <div class='mt-6 p-4 bg-gray-50 rounded-md' id='verification-result'></div>
                    </div>
                </div>
            </div>
        </div>
    ";
}

employeeLayout($singleDocumentContent);
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('verify-form');
        const resultDiv = document.getElementById('verification-result');
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('image');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight the drop area when dragging over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);
        dropArea.addEventListener('click', () => fileInput.click());

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-100');
        }

        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-100');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                fileInput.files = files; // Set the file input's files property
                resultDiv.textContent = `Selected file: ${files[0].name}`; // Display selected file name
            }
        }

        form.onsubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    // Clear previous result
    resultDiv.textContent = 'Verifying document...';

    // Submit the form data to the PHP backend
    try {
        const response = await fetch('http://localhost/group69/api/verify.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.success) {
            resultDiv.innerHTML = `<p class="text-green-600">Verification successful: ${result.message}</p>`;
        } else {
            resultDiv.innerHTML = `<p class="text-red-600">Error: ${result.message}</p>`;
        }

        // Auto reload the page after 5 seconds
        setTimeout(() => {
            location.reload();
        }, 5000); // 5000 milliseconds = 5 seconds

    } catch (error) {
        resultDiv.innerHTML = `<p class="text-red-600">Error: ${error.message}</p>`;
        
        // Auto reload the page after 5 seconds, even on error
        setTimeout(() => {
            location.reload();
        }, 5000);
    }
};

    });
</script>
