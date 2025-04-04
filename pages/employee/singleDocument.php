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
    $imageUrl = "https://civilregistrar.lgu2.com/api/{$document['image']}"; // Use the image path directly

    $singleDocumentContent = "
        <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
            <div class='flex items-center space-x-2 p-4'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M7 8V3a2 2 0 012-2h6a2 2 0 012 2v5m-4 4h4m-5 0h-3a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2v-6a2 2 0 00-2-2H9z'/>
                </svg> 
                <h1 class='text-2xl font-bold text-gray-800'>VERIFYING SUPPORTING DOCUMENTS</h1>
            </div>

            <div class='grid grid-cols-1 md:grid-cols-2 place-items-center w-[88%] mx-auto mt-5'>
                <div class='bg-green-400 p-2 rounded-sm'>
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
                            <button type='submit' class='w-full bg-indigo-600 text-white py-2 rounded-md'>Verify Identify</button>
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

    // Show spinner while verifying
    resultDiv.innerHTML = `
        <div class="flex items-center space-x-2">
            <svg class='animate-spin h-6 w-6 text-blue-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                <circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle>
                <path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8v8H4z'></path>
            </svg>
            <p class="text-gray-700">Verifying document...</p>
        </div>
    `;

    // Submit the form data to the PHP backend
    try {
        const response = await fetch('https://civilregistrar.lgu2.com/api/verify.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        
        // Remove spinner and show result
        if (result.success) {
                    // Auto reload the page after 5 seconds
                setTimeout(() => {
                    
                    resultDiv.innerHTML = `<p class="text-green-600">Verification successful: ${result.message}</p>`;
                }, 7000);
            
        } else {
            resultDiv.innerHTML = `<p class="text-red-600">Error: ${result.message}</p>`;
        }

        

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
