<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "   
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>

       <div class='flex items-center space-x-2 p-4'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M9 12l2 2 4-4m0 0L15 6l4 4m-4 4h3m0 0v6m-3 0h-6'/>
                </svg>
                <h1 class='text-2xl font-bold text-gray-800'>VERIFICATION OF SUPPORTING DOCUMENTS</h1>
        </div> 

        <div class='flex items-center mb-6 mt-4 w-[88%] mx-auto justify-center'>

            <div class='relative w-full flex justify-center'>
                <input type='text' id='searchInput' 
                    placeholder='Search by User ID, Full Name, or Verification Type...' 
                    class='shadow appearance-none border border-gray-300 rounded-md w-[60%] py-3 pl-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500'>
                <svg class='absolute right-[14rem] top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 2a9 9 0 100 18 9 9 0 000-18zM22 22l-5.5-5.5' />
                </svg>
            </div>


        </div>

        <div class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-[88%] mx-auto mt-[4rem]' id='documentsContainer'>
            <!-- Employee cards will be injected here dynamically -->
        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>

<script>
    // Function to fetch employee verification documents
    async function fetchVerificationDocuments(searchTerm = '') {
        try {
            // Prepare the API URL with the search term as a query parameter
            const apiUrl = `http://localhost/group69/api/verification.php?search=${encodeURIComponent(searchTerm)}`;

            const response = await fetch(apiUrl);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            const documents = await response.json(); // Assuming the server returns JSON data
            displayDocuments(documents); // Call function to display data
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
        }
    }

    // Function to display the fetched documents
    // Function to display the fetched documents
    function displayDocuments(documents) {
    const container = document.getElementById('documentsContainer');
    container.innerHTML = ''; // Clear existing content

    if (!Array.isArray(documents) || documents.length === 0) {
        container.innerHTML = "<p class='text-gray-700'>No verification documents found.</p>";
        return;
    }

    documents.forEach(document => {

        const card = `
            <a href='http://localhost/group69/pages/employee/singleDocument.php?id=${document.id}' class='bg-white shadow-md rounded-lg p-4 block hover:shadow-lg transition-shadow'>
                <img src='${document.image}' alt='Verification Document' class='w-full h-32 object-cover rounded-md mb-2' onerror="this.onerror=null; this.src='path/to/placeholder.jpg';"> <!-- Optional placeholder -->
                <h2 class='text-xl font-bold'>${document.full_name}</h2>
                <p class='text-gray-700'>User ID: <span class='font-medium'>${document.user_id}</span></p>
                <p class='text-gray-700'>Date of Birth: <span class='font-medium'>${document.date_of_birth}</span></p>
                <p class='text-gray-700'>Address: <span class='font-medium'>${document.address}</span></p>
                <p class='text-gray-700'>Phone: <span class='font-medium'>${document.phone}</span></p>
                <p class='text-gray-700'>Verification Type: <span class='font-medium'>${document.verification_type}</span></p>
            </a>
        `;
        container.insertAdjacentHTML('beforeend', card); // Append card to the grid
    });
}

    // Fetch all documents on page load
    document.addEventListener('DOMContentLoaded', () => {
        fetchVerificationDocuments(); // Fetch all documents
    });

    // Fetch by filters when the input changes
    document.getElementById('searchInput').addEventListener('keyup', () => {
        const searchTerm = document.getElementById('searchInput').value.trim(); // Get search term from input
        fetchVerificationDocuments(searchTerm); // Fetch documents based on the search term
    });
</script>
