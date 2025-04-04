<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

// Define the content for the create announcement page
$announcementContent = "
<div class='flex flex-col'>
       <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 4h.01M3 10h18M3 14h18M6 18h12M3 6h18'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>ANNOUNCEMENT</h1>
        </div>
    <div class='container mx-auto my-10'>

        <form id='announcementForm' enctype='multipart/form-data' class='bg-white p-5 rounded shadow-md grid grid-cols-1 md:grid-cols-2 gap-4 w-[88%] mx-auto'>
           <input type='hidden' id='userId' name='userId'> <!-- Hidden User ID -->
            <div class='mb-4'>
                <label for='title' class='block text-sm font-medium text-gray-700'>Title</label>
                <input type='text' name='title' id='title' placeholder='Title' required class='mt-1 block w-full border border-gray-300 rounded-md p-2'>
            </div>

             <div class='mb-4'>
                <label for='announcement_type' class='block text-sm font-medium text-gray-700'>Announcement Type</label>
                <select name='announcement_type' id='announcement_type' required class='mt-1 block w-full border border-gray-300 rounded-md p-2'>
                    <option value='' disabled selected>Select Option</option>
                    <option value='employee'>Employee Announcement</option>
                    <option value='resident'>Resident Announcement</option>
                </select>
            </div>

            <div class='mb-4'>
                <label for='description' class='block text-sm font-medium text-gray-700'>Description</label>
                <textarea name='description' id='description' placeholder='Description' required class='mt-1 block w-full border border-gray-300 rounded-md p-2'></textarea>
            </div>

            <div class='mb-4'>
                <label for='image' class='block text-sm font-medium text-gray-700'>Image</label>
                <input type='file' name='image' id='image' accept='image/*' required class='mt-1 block w-full border border-gray-300 rounded-md p-2'>
            </div>

            <div class='col-span-1 md:col-span-2'>
                <input type='submit' value='Submit Announcement' class='bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 w-full cursor-pointer'>
            </div>
        </form>
    </div>
</div>
";

// Call the layout function with the announcement creation page content
adminLayout($announcementContent);
?>
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
    // Set userId from localStorage
    document.getElementById('userId').value = localStorage.getItem('userId') || '';

    document.getElementById('announcementForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        
      


        try {
            const response = await fetch('http://localhost/group69/api/announcements.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                showToast(result.message, 'success');
                this.reset(); // Reset the form fields
            } else {
                showToast(result.error || 'Error occurred', 'error');
            }
        } catch (error) {
            showToast('Network error: ' + error.message, 'error');
        }
    });

    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)',
            },
            duration: 3000,
        }).showToast();
    }
</script>