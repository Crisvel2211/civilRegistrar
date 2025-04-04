<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

// Define the content for the home page
$homeContent = "
<div class='flex flex-col container mx-auto w-full h-[88vh] overflow-y-scroll'>
    <!-- Main Container -->
    <div class='flex items-center space-x-2 p-4'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M17 20h5v-2h-5v2zm-6 0h-5v-2h5v2zm-5-3h5v-2H6v2zm0-3h5v-2H6v2zm0-3h5V8H6v2zm0-3h5V5H6v2zm6 3h5V8h-5v2zm6 0h5V8h-5v2z'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>USERS</h1>
    </div>

    <div class='container mx-auto my-10'>
    
        <div class='bg-white p-6 rounded-lg shadow-lg w-[88%] mx-auto'>
            <!-- Search Box and Role Filter -->
            <div class='mb-6 flex items-center justify-between w-full'>
                <input type='text' id='searchInput' placeholder='Search by name' class='w-[80%] p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4'>
                <select id='roleFilter' class='w-[15%] p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4'>
                    <option value=''>All</option>
                    <option value='admin'>Admin</option>
                    <option value='employee'>Employee</option>
                    <option value='resident'>Resident</option>
                </select>
            </div>

            <!-- Users Table -->
            <div class='flex justify-between item-center mb-4'>
             <h2 class='text-2xl '>Lists Of User</h2>
             <button id='addUserBtn' class='bg-indigo-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-indigo-700'>Add User</button>
            </div>
           
            <div class='w-full overflow-x-auto md:overflow-none mt-2'>
             <table class='w-full table-auto mb-6'>
                <thead class='bg-gray-200'>
                    <tr>
                        <th class='px-4 py-2'>ID</th>
                        <th class='px-4 py-2'>Name</th>
                        <th class='px-4 py-2'>Email</th>
                        <th class='px-4 py-2'>Role</th>
                        <th class='px-4 py-2'>Actions</th>
                    </tr>
                </thead>
                <tbody id='usersTable' class='divide-y divide-gray-300'>
                        <!-- Data will be inserted here dynamically -->
                </tbody>    
            </table>
            
            </div>
        </div>
    </div>
</div>

<!-- Add/Update User Modal -->
<div id='userModal' class='fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden'>
    <div class='bg-white p-6 rounded-lg shadow-lg w-1/3'>
        <h2 id='formTitle' class='text-2xl mb-4'>Add User</h2>
        <form id='addUserForm' class='space-y-4'>
            <input type='hidden' id='userId'> <!-- Hidden input for the user ID -->
            <div>
                <input type='text' id='userName' placeholder='Name' class='w-full p-2 border border-gray-300 rounded'>
            </div>
            <div>
                <input type='text' id='userEmail' placeholder='Email' class='w-full p-2 border border-gray-300 rounded'>
            </div>
            <div>
                <input type='password' id='userPassword' class='w-full p-2 border border-gray-300 rounded' placeholder='Password'>
            </div>
            <div>
                <select id='userRole' class='w-full p-2 border border-gray-300 rounded' required>
                    <option value=''>Select Role</option>
                    <option value='admin'>Admin</option>
                    <option value='employee'>Employee</option>
                    <option value='resident'>Resident</option>
                </select>
            </div>
            <div class='flex justify-between mt-4'>
                <input type='submit' value='Add User' id='submitButton' class='mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 cursor-pointer'>
                <button id='closeModalBtn' class='mt-4 bg-red-500 text-white px-4 py-2 rounded'>Close</button>
            </div>
        </form>
        
    </div>
</div>

<!-- Delete User Modal -->
<div id='deleteUserModal' class='fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden'>
    <div class='bg-white p-6 rounded-lg shadow-lg w-1/3'>
        <h2 class='text-2xl mb-4'>Delete User</h2>
        <p>Are you sure you want to delete this user?</p>
        <div class='flex justify-between mt-4'>
            <button id='confirmDeleteBtn' class='bg-red-500 text-white px-4 py-2 rounded'>Delete</button>
            <button id='cancelDeleteBtn' class='bg-gray-300 text-gray-800 px-4 py-2 rounded'>Cancel</button>
        </div>
    </div>
</div>
";

// Call the layout function with the home page content
adminLayout($homeContent);
?>

<!-- Toastify JS -->
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
    // Show toast notifications
    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)'
            },
            duration: 3000
        }).showToast();
    }

    // Load users from the API
    function loadUsers(search = '', role = '') {
        const url = `https://civilregistrar.lgu2.com/api/users.php${search || role ? `?${search ? `search=${search}` : ''}${search && role ? '&' : ''}${role ? `role=${role}` : ''}` : ''}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(users => {
            if(Array.isArray(users)){
                const usersTable = document.querySelector('#usersTable');
                usersTable.innerHTML='';

                users.forEach(user => {
                    const row = `
                     <tr class='border-b border-x border-gray-300'>
                            <td class='px-4 py-2 border-r border-gray-300'>${user.id}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${user.name}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${user.email}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${user.role}</td> 
                            <td class='px-4 py-2 flex justify-around'>
                                <button class='text-blue-500 hover:text-blue-400' onclick='editUser(${user.id}, "${user.name}", "${user.email}", "${user.role}")'>
                                    <i class='fas fa-sync-alt'></i> 
                                </button>
                                <button class='text-red-500 hover:text-red-400' onclick='confirmDeleteUser(${user.id})'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    usersTable.innerHTML += row;
                });
            }else {
                console.error('Error fetching data:', users);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading users!', 'error');
        });
    }
// Add user function using async/await
async function addUser(name, email, password, role) {
    try {
        const response = await fetch('https://civilregistrar.lgu2.com/api/users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, email, password, role })
        });

        const data = await response.json();

        if (response.ok) {
            showToast('Added successfully', 'success'); // Notification only once
            loadUsers(); // Reload the users list dynamically
            document.getElementById('addUserForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('submitButton').value = 'Add User';
            closeModal();
            setTimeout(() => {
            window.location.reload();
        }, 2000);
        } else {
            showToast(data.error || 'Error adding user!', 'error');
        }
    } catch (error) {
        showToast('Network error or server is down!', 'error');
    }
}





   // Populate the form with user data for editing
function editUser(id, name, email, role) {
    document.getElementById('userId').value = id;
    document.getElementById('userName').value = name;
    document.getElementById('userEmail').value = email;
    document.getElementById('userRole').value = role;

    // Disable the name, email, and password fields
    document.getElementById('userName').disabled = true;
    document.getElementById('userEmail').disabled = true;
    document.getElementById('userPassword').disabled = true;

    document.getElementById('formTitle').textContent = 'Update User';
    document.getElementById('submitButton').value = 'Update User';
    openModal();
}

document.getElementById('addUserForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const id = document.getElementById('userId').value;
    const name = document.getElementById('userName').value;
    const email = document.getElementById('userEmail').value;
    const password = document.getElementById('userPassword').value;
    const role = document.getElementById('userRole').value;

    if (id) {
        updateUser(id, name, email, password, role);
    } else {
        addUser(name, email, password, role);
    }
}, { once: true }); // This ensures the event listener runs only once


// Update user function
function updateUser(id, name, email, password, role) {
    const userRole = localStorage.getItem('role');
    const userId = localStorage.getItem('userId');

    fetch('https://civilregistrar.lgu2.com/api/users.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'userRole': userRole,
            'userId': userId
        },
        body: JSON.stringify({ id, name, email, password, role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showToast(data.error, 'error');
        } else {
            showToast(data.message, 'success');
            loadUsers();
            closeModal();
            document.getElementById('addUserForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('submitButton').value = 'Add User';
            setTimeout(() => {
            window.location.reload();
        }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating user role!', 'error');
    });
}

function deleteUser(id) {
    fetch('https://civilregistrar.lgu2.com/api/users.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        loadUsers(); // Reload the users list
        closeDeleteModal();
        
        // Reload the page after a short delay (optional)
        setTimeout(() => {
            window.location.reload();
        }, 2000); // Reload after 1 second
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error deleting user!', 'error');
    });
}

document.getElementById('addUserForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const id = document.getElementById('userId').value;
    const name = document.getElementById('userName').value;
    const email = document.getElementById('userEmail').value;
    const password = document.getElementById('userPassword').value;
    const role = document.getElementById('userRole').value;

    if (id) {
        updateUser(id, name, email, password, role);
    } else {
        addUser(name, email, password, role);
    }
});


    // Open and close modals
    function openModal() {
        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('addUserForm').reset(); // Reset the form fields
    document.getElementById('userId').value = ''; // Reset the user ID field
    document.getElementById('submitButton').value = 'Add User';
}

    function openDeleteModal() {
        document.getElementById('deleteUserModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }

    // Open the modal for adding user
    document.getElementById('addUserBtn').addEventListener('click', openModal);

    // Close modal for add/edit user
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);

    // Confirm delete user
    function confirmDeleteUser(id) {
        openDeleteModal();

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            deleteUser(id);
        });

        document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
    }

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('userModal');
        const deletemodal = document.getElementById('deleteUserModal');
        
        if (e.target === modal) {
            closeModal();
        }
        if (e.target === deletemodal) {
            closeDeleteModal();
        }
    });


    // Search and filter users
    document.getElementById('searchInput').addEventListener('input', function() {
        loadUsers(this.value, document.getElementById('roleFilter').value);
    });

    document.getElementById('roleFilter').addEventListener('change', function() {
        loadUsers(document.getElementById('searchInput').value, this.value);
    });


    // Initial Load Users
    loadUsers();
</script>
