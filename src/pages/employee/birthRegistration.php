<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
        <div class='container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg'>
        
            <!-- Search and Filter Section -->
            <div class='flex items-center justify-between mb-6'>
                <input type='text' id='searchInput' placeholder='Search by first name' class='w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4'>
                
                <select id='statusFilter' class='p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400'>
                    <option value=''>All</option>
                    <option value='pending'>Pending</option>
                    <option value='processing'>Processing</option>
                    <option value='verified'>Verified</option>
                    <option value='completed'>Completed</option>
                </select>
            </div>

            <!-- Birth Registration Table -->
            <table class='min-w-full table-auto bg-white'>
                <thead class='bg-gray-200'>
                    <tr>
                        <th class='px-4 py-2'>ID</th>
                        <th class='px-4 py-2'>Resident Name</th> <!-- New column for userId -->
                        <th class='px-4 py-2'>Status</th>
                        <th class='px-4 py-2'>Verification</th>
                        <th class='px-4 py-2'>Actions</th>
                    </tr>
                </thead>
                <tbody id='usersTable' class='divide-y divide-gray-300'>
                    <!-- Data will be inserted here dynamically -->
                </tbody>
            </table>


            <!-- Status Update Modal -->
            <div id='statusUpdateModal' class='fixed inset-0 items-center justify-center z-50 hidden'>
                <div class='bg-white p-5 rounded shadow-lg w-1/3'>
                    <h2 class='text-lg font-semibold mb-4'>Update Status</h2>
                    <select id='newStatusInput' class='w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4'>
                        <option value=''>Select Status</option>
                        <option value='pending'>Pending</option>
                        <option value='processing'>Processing</option>
                        <option value='verified'>Verified</option>
                        <option value='completed'>Completed</option>
                    </select>
                    <div class='flex justify-end'>
                        <button id='modalCancelButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Cancel</button>
                        <button id='modalConfirmButton' class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 ml-2'>Confirm</button>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id='deleteConfirmationModal' class='fixed inset-0 items-center justify-center z-50 hidden'>
                <div class='bg-white p-5 rounded shadow-lg w-1/3'>
                    <h2 class='text-lg font-semibold mb-4'>Delete Confirmation</h2>
                    <p>Are you sure you want to delete this birth registration?</p>
                    <div class='flex justify-end'>
                        <button id='deleteModalCancelButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Cancel</button>
                        <button id='deleteModalConfirmButton' class='bg-red-500 text-white px-4 py-1 rounded hover:bg-red-400 ml-2'>Delete</button>
                    </div>
                </div>
            </div>

            <!-- View Birth Registration Modal -->
            <div id='viewBirthModal' class='fixed inset-0 items-center justify-center z-50 hidden'>
                <div class='bg-white p-5 rounded shadow-lg w-1/3'>
                    <h2 class='text-lg font-semibold mb-4'>Birth Registration Details</h2>
                    <div id='birthDetailsContent' class='mb-4'>
                        <!-- Details will be populated here -->
                    </div>
                    <div class='flex justify-end'>
                        <button id='viewModalCloseButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Close</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
// Fetch the list of birth registrations for the specific employee
const fetchBirthRegistrations = () => {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const employeeId = localStorage.getItem('userId'); // Replace with the logged-in employee's ID

    // Make sure to encode the search parameter for safe URL usage
    const encodedSearch = encodeURIComponent(search);

    fetch(`http://localhost/civil-registrar/api/birth.php?employee_id=${employeeId}&search=${encodedSearch}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                const tableBody = document.querySelector('#usersTable');
                tableBody.innerHTML = ''; // Clear previous entries

                data.forEach(birth => {
                    const row = `
                        <tr>
                            <td class='px-4 py-2'>${birth.id}</td>
                            <td class='px-4 py-2'>${birth.user_name}</td> <!-- Display user name here -->
                            <td class='px-4 py-2 text-center'>
                                <span class='${birth.status === "verified" ? "bg-green-200" : "bg-yellow-200"} text-green-800 text-xs font-medium px-2.5 py-0.5 rounded'>
                                    ${birth.status}
                                </span>
                            </td>
                            <td class='px-4 py-2'>
                                <button class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 transition duration-300' onclick='viewBirth(${birth.id})'>View</button>
                            </td>
                            <td class='px-4 py-2 flex space-x-4'>
                                <button class='text-blue-500 hover:text-blue-400' onclick='updateStatus(${birth.id})'>
                                    <i class='fas fa-sync-alt'></i> 
                                </button>
                                <button class='text-red-500 hover:text-red-400' onclick='confirmDelete(${birth.id})'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                console.error('Error fetching data:', data);
            }
        })
        .catch(error => console.error('Error:', error));
};



// Call the function when the page loads or filters are changed
document.getElementById('searchInput').addEventListener('input', fetchBirthRegistrations);
document.getElementById('statusFilter').addEventListener('change', fetchBirthRegistrations);
fetchBirthRegistrations(); // Initial call to fetch data

let currentBirthId = null; // Variable to hold the current birth ID for updating status

function updateStatus(birthId) {
    currentBirthId = birthId; // Set the current birth ID
    document.getElementById('statusUpdateModal').classList.remove('hidden'); // Show the modal
}

document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value; // Get the selected value
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        // Prepare data for the update
        const updatedData = {
            id: currentBirthId,
            status: newStatus,
            employee_id: employeeId
        };

        // Send the update request
        fetch(`http://localhost/civil-registrar/api/birth.php`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success'); // Show success message
                fetchBirthRegistrations(); // Refresh the table
            } else {
                showToast(data.message || 'An error occurred'); // Handle error
            }
        })
        .catch(error => console.error('Error:', error));

        document.getElementById('statusUpdateModal').classList.add('hidden'); // Hide the modal after submission
        document.getElementById('newStatusInput').value = ''; // Reset the select input
    } else {
        showToast('Please select a status.'); // Alert if input is empty
    }
});

// Close modal on cancel button click
document.getElementById('modalCancelButton').addEventListener('click', () => {
    document.getElementById('statusUpdateModal').classList.add('hidden'); // Hide the modal
    document.getElementById('newStatusInput').value = ''; // Reset the select input
});

// Confirm deletion of a birth registration
function confirmDelete(birthId) {
    currentBirthId = birthId; // Set the current birth ID for deletion
    document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show delete confirmation modal
}

// Handle the confirmation of deletion
document.getElementById('deleteModalConfirmButton').addEventListener('click', () => {
    const employeeId = localStorage.getItem('userId');

    // Send the delete request
    fetch(`http://localhost/civil-registrar/api/birth.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: currentBirthId, employee_id: employeeId }) // Include employee ID if needed
    })
    .then(response => response.json())
    .then(data => {
        // Check for success message
        if (data.message) {
            showToast(data.message, 'error'); // Show success message
            fetchBirthRegistrations(); // Refresh the table after deletion
        } else if (data.error) {
            showToast(data.error || 'An error occurred'); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An unexpected error occurred.', 'error'); // Handle fetch error
    });

    document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide the modal after submission
});

// Close modal on cancel button click
document.getElementById('deleteModalCancelButton').addEventListener('click', () => {
    document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide the modal
});


function viewBirth(birthId) {
    // Fetch the birth registration details
    fetch(`http://localhost/civil-registrar/api/birth.php?id=${birthId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the modal with birth registration details
                const birthDetailsContent = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Child Name:</strong> ${data.child_first_name} ${data.child_middle_name} ${data.child_last_name}</p>
                    <p><strong>Sex:</strong> ${data.child_sex}</p>
                    <p><strong>Date of Birth:</strong> ${data.child_date_of_birth}</p>
                    <p><strong>Time of Birth:</strong> ${data.child_time_of_birth}</p>
                    <p><strong>Place of Birth:</strong> ${data.child_place_of_birth}</p>
                    <p><strong>Birth Type:</strong> ${data.child_birth_type}</p>
                    <p><strong>Birth Order:</strong> ${data.child_birth_order}</p>
                    <p><strong>Father Name:</strong> ${data.father_first_name} ${data.father_middle_name} ${data.father_last_name} ${data.father_suffix}</p>
                    <p><strong>Father Nationality:</strong> ${data.father_nationality}</p>
                    <p><strong>Father Date of Birth:</strong> ${data.father_date_of_birth}</p>
                    <p><strong>Mother Name:</strong> ${data.mother_first_name} ${data.mother_middle_name} ${data.mother_last_name} (née ${data.mother_maiden_name})</p>
                    <p><strong>Mother Nationality:</strong> ${data.mother_nationality}</p>
                    <p><strong>Mother Date of Birth:</strong> ${data.mother_date_of_birth}</p>
                    <p><strong>Parents Married at Birth:</strong> ${data.parents_married_at_birth}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Created At:</strong> ${data.created_at}</p>
                `;
                document.getElementById('birthDetailsContent').innerHTML = birthDetailsContent; // Populate modal content
                document.getElementById('viewBirthModal').classList.remove('hidden'); // Show the modal
            } else {
                showToast('Birth registration not found.', 'error'); // Handle error
            }
        })
        .catch(error => console.error('Error fetching birth registration details:', error));
}

// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewBirthModal').classList.add('hidden'); // Hide the modal
});





</script>
