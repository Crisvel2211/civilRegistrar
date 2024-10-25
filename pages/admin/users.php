<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

// Define the content for the home page
$homeContent = "
<div class='flex flex-col container mx-auto w-full h-[88vh] overflow-y-scroll'>
    <!-- Main Container -->
    <div class='container mx-auto my-10'>
        <div class='bg-white p-6 rounded-lg shadow-lg'>
            <!-- Search Box and Role Filter -->
            <div class='mb-6 flex items-center space-x-4'>
                <input type='text' id='searchInput' placeholder='Search by name' class='w-full p-2 border border-gray-300 rounded'>
                <select id='roleFilter' class='p-2 border border-gray-300 rounded'>
                    <option value=''>All</option>
                    <option value='admin'>Admin</option>
                    <option value='employee'>Employee</option>
                    <option value='resident'>Resident</option>
                </select>
            </div>

            <!-- Users Table -->
            <div class='flex justify-between item-center mb-4'>
             <h2 class='text-2xl '>Lists Of User</h2>
             
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
           

            <!-- Add/Update User Form -->
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
                <div>
                    <input type='submit' value='Add User' id='submitButton' class='bg-gray-800 text-white px-4 py-2 rounded cursor-pointer hover:bg-gray-700'>
                </div>
            </form>

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
        const url = `http://localhost/civil-registrar/api/users.php${search || role ? `?${search ? `search=${search}` : ''}${search && role ? '&' : ''}${role ? `role=${role}` : ''}` : ''}`;

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
                                <button class='text-blue-500 hover:text-blue-400'  onclick='editUser(${user.id}, "${user.name}", "${user.email}", "${user.role}")'>
                                    <i class='fas fa-sync-alt'></i> 
                                </button>
                                <button class='text-red-500 hover:text-red-400' onclick='deleteUser(${user.id})'>
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

    // Add user function
    function addUser(name, email, password, role) {
        fetch('http://localhost/civil-registrar/api/users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, email, password, role })
        })
        .then(response => response.json())
        .then(data => {
            showToast(data.message, 'success');
            loadUsers();
            document.getElementById('addUserForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('submitButton').value = 'Add User';
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error adding user!', 'error');
        });
    }

    // Populate the form with user data for editing
    function editUser(id, name, email, role) {
        document.getElementById('userId').value = id;
        document.getElementById('userName').value = name;
        document.getElementById('userEmail').value = email;
        document.getElementById('userRole').value = role;
        document.getElementById('formTitle').textContent = 'Update User';
        document.getElementById('submitButton').value = 'Update User';

        // Enable input fields for editing
        document.getElementById('userName').disabled = true;
        document.getElementById('userEmail').disabled = true;
        document.getElementById('userPassword').disabled = true; // Allow password editing as well
    }

    // Update user function
    function updateUser(id, name, email, password, role) {
        const userRole = localStorage.getItem('role');
        const userId = localStorage.getItem('userId');

        fetch('http://localhost/civil-registrar/api/users.php', {
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
                document.getElementById('addUserForm').reset();
                document.getElementById('userId').value = '';
                document.getElementById('submitButton').value = 'Add User';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating user role!', 'error');
        });
    }

    // Delete a user
    function deleteUser(id) {
    fetch('http://localhost/civil-registrar/api/users.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message || data.error, data.message ? 'success' : 'error');
        loadUsers(); // Reload users after deletion
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error deleting user!', 'error');
    });
}

    // Form submission handler
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const userId = document.getElementById('userId').value;
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const password = document.getElementById('userPassword').value;
        const role = document.getElementById('userRole').value;

        if (userId) {
            // If a user ID exists, we are updating the user
            updateUser(userId, name, email, password, role);
        } else {
            // Otherwise, we are adding a new user
            addUser(name, email, password, role);
        }
    });

    // Search and filter users
    document.getElementById('searchInput').addEventListener('input', function() {
        loadUsers(this.value, document.getElementById('roleFilter').value);
    });

    document.getElementById('roleFilter').addEventListener('change', function() {
        loadUsers(document.getElementById('searchInput').value, this.value);
    });

    // Initial load
    loadUsers();
</script>
