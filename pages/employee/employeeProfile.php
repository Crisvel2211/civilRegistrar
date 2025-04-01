<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Define the content for the update profile page
$updateProfileContent = "
 <div class='flex flex-col'>
    <div class='container mx-auto my-10'>
        <div class='bg-white p-6 rounded-lg shadow-lg'>
            <h2 class='text-2xl mb-4'>Update Profile</h2>
            <form id='updateProfileForm' class='space-y-4'>
                <div>
                    <input type='text' id='userName' placeholder='Name' class='w-full p-2 border border-gray-300 rounded' required>
                </div>
                <div>
                    <input type='text' id='userEmail' placeholder='Email' class='w-full p-2 border border-gray-300 rounded' required>
                </div>
                <div>
                    <input type='password' id='userPassword' class='w-full p-2 border border-gray-300 rounded' placeholder='New Password (optional)'>
                </div>
                <div>
                    <label class='block text-gray-700'>Role:</label>
                    <p id='userRole' class='w-full p-2 border border-gray-300 rounded bg-gray-100' readonly></p>
                </div>
                <div>
                    <input type='submit' value='Update Profile' id='submitButton' class='bg-gray-800 text-white px-4 py-2 rounded cursor-pointer hover:bg-gray-700'>
                </div>
            </form>
        </div>
    </div>
</div>
";
// Call the layout function with the update profile page content
employeeLayout($updateProfileContent);
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
        fetch(`http://localhost/group69/api/users.php?id=${userId}`)
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
        fetch('http://localhost/group69/api/users.php', {
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
