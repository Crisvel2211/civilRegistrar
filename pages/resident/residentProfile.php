<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the update profile page
$updateProfileContent = "
 <div class='flex flex-col'>
 <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>PROFILE</h1>
        </div>
    <div class='container mx-auto my-10'>
        <div class='bg-white p-6 rounded-lg shadow-lg mx-auto w-[88%]'>
            <h2 class='text-2xl mb-4'>Update Profile</h2>
        <form id='updateProfileForm' class='grid grid-cols-2 gap-4'>
            <div>
                <label for='userName' class='block text-gray-700 mb-1'>Name</label>
                <input type='text' id='userName' placeholder='Enter your name' class='w-full p-2 border border-gray-300 rounded' required>
            </div>
            <div>
                <label for='userEmail' class='block text-gray-700 mb-1'>Email</label>
                <input type='text' id='userEmail' placeholder='Enter your email' class='w-full p-2 border border-gray-300 rounded' required>
            </div>
            <div>
                <label for='userPassword' class='block text-gray-700 mb-1'>New Password (optional)</label>
                <input type='password' id='userPassword' class='w-full p-2 border border-gray-300 rounded' placeholder='Enter new password'>
            </div>
            <div>
                <label for='userRole' class='block text-gray-700 mb-1'>Role</label>
                <p id='userRole' class='w-full p-2 border border-gray-300 rounded bg-gray-100' readonly></p>
            </div>
            <div class='col-span-2'>
                <input type='submit' value='Update Profile' id='submitButton' class='bg-indigo-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-indigo-700'>
            </div>
        </form>

        </div>
    </div>
</div>
";
// Call the layout function with the update profile page content
residentLayout($updateProfileContent);
?>

<!-- Toastify JS -->
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)'
            },
            duration: 3000
        }).showToast();
    }

    function loadUserProfile() {
        const userId = localStorage.getItem('userId'); // Get userId from local storage
        fetch(`https://civilregistrar.lgu2.com/api/users.php?id=${userId}`)
            .then(response => response.json())
            .then(user => {
                document.getElementById('userName').value = user.name;
                document.getElementById('userEmail').value = user.email;
                document.getElementById('userRole').innerText = user.role; // Set role as text
            })
            .catch(error => {
                console.error('Error loading user profile:', error);
                showToast('Error loading user profile!', 'error');
            });
    }

    function updateUserProfile(id, name, email, password) {
    const userId = localStorage.getItem('userId'); // Get userId from local storage
    const role = document.getElementById('userRole').innerText; // Get role from the DOM
    fetch('https://civilregistrar.lgu2.com/api/users.php', {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'userId': userId,
        'userRole': localStorage.getItem('userRole') // Add userRole to headers
    },
    body: JSON.stringify({ id, name, email, password, role }) // Include role
})

    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        loadUserProfile(); // Reload profile to reflect changes
    })
    .catch(error => {
        console.error('Error updating user profile:', error);
        showToast('Error updating profile!', 'error');
    });
}


    document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const password = document.getElementById('userPassword').value;
        const userId = localStorage.getItem('userId'); // Get userId from local storage
        updateUserProfile(userId, name, email, password);
    });

    // Initial load
    loadUserProfile();
</script>
