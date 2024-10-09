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

            <!-- death Registration Table -->
            <div class='w-full overflow-x-auto'> <!-- Wrapper for responsiveness -->
                <table class='w-full table-auto bg-white'>
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
            </div>



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
                    <p>Are you sure you want to delete this death registration?</p>
                    <div class='flex justify-end'>
                        <button id='deleteModalCancelButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Cancel</button>
                        <button id='deleteModalConfirmButton' class='bg-red-500 text-white px-4 py-1 rounded hover:bg-red-400 ml-2'>Delete</button>
                    </div>
                </div>
            </div>

            <!-- View death Registration Modal -->
            <div id='viewdeathModal' class='fixed inset-0 items-center justify-center z-50 hidden'>
                <div class='bg-white p-5 rounded shadow-lg w-1/3'>
                    <h2 class='text-lg font-semibold mb-4'>death Registration Details</h2>
                    <div id='deathDetailsContent' class='mb-4'>
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
// Fetch the list of death registrations for the specific employee
const fetchdeathRegistrations = () => {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const employeeId = localStorage.getItem('userId'); // Replace with the logged-in employee's ID

    // Make sure to encode the search parameter for safe URL usage
    const encodedSearch = encodeURIComponent(search);

    fetch(`http://localhost/civil-registrar/api/death.php?employee_id=${employeeId}&search=${encodedSearch}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                const tableBody = document.querySelector('#usersTable');
                tableBody.innerHTML = ''; // Clear previous entries

                data.forEach(death => {
                    const row = `
                        <tr>
                            <td class='px-4 py-2'>${death.id}</td>
                            <td class='px-4 py-2'>${death.user_name}</td> <!-- Display user name here -->
                            <td class='px-4 py-2 text-center'>
                                <span class='${(death.status === "verified" || death.status === "completed") ? "bg-green-300 text-green-800" : "bg-yellow-300 text-yellow-800"} text-xs font-medium px-2.5 py-0.5 rounded'>
                                    ${death.status}
                                </span>
                            </td>
                            <td class='px-4 py-2'>
                                <button class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 transition duration-300' onclick='viewdeath(${death.id})'>View</button>
                            </td>
                            <td class='px-4 py-2 flex space-x-4'>
                                <button class='text-blue-500 hover:text-blue-400' onclick='updateStatus(${death.id})'>
                                    <i class='fas fa-sync-alt'></i> 
                                </button>
                                <button class='text-red-500 hover:text-red-400' onclick='confirmDelete(${death.id})'>
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
document.getElementById('searchInput').addEventListener('input', fetchdeathRegistrations);
document.getElementById('statusFilter').addEventListener('change', fetchdeathRegistrations);
fetchdeathRegistrations(); // Initial call to fetch data

let currentdeathId = null; // Variable to hold the current death ID for updating status

function updateStatus(deathId) {
    currentdeathId = deathId; // Set the current death ID
    document.getElementById('statusUpdateModal').classList.remove('hidden'); // Show the modal
}

document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value; // Get the selected value
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        // Prepare data for the update
        const updatedData = {
            id: currentdeathId,
            status: newStatus,
            employee_id: employeeId
        };

        // Send the update request
        fetch(`http://localhost/civil-registrar/api/death.php`, {
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
                fetchdeathRegistrations(); // Refresh the table
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

// Confirm deletion of a death registration
function confirmDelete(deathId) {
    currentdeathId = deathId; // Set the current death ID for deletion
    document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show delete confirmation modal
}

// Handle the confirmation of deletion
document.getElementById('deleteModalConfirmButton').addEventListener('click', () => {
    const employeeId = localStorage.getItem('userId');

    // Send the delete request
    fetch(`http://localhost/civil-registrar/api/death.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: currentdeathId, employee_id: employeeId }) // Include employee ID if needed
    })
    .then(response => response.json())
    .then(data => {
        // Check for success message
        if (data.message) {
            showToast(data.message, 'error'); // Show success message
            fetchdeathRegistrations(); // Refresh the table after deletion
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


function viewdeath(deathId) {
    // Fetch the death registration details
    fetch(`http://localhost/civil-registrar/api/death.php?id=${deathId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the modal with death registration details
                const deathDetailsContent = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Deceased's First Name:</strong> ${data.deceased_first_name} ${data.deceased_middle_name} ${data.deceased_last_name}</p>
                    <p><strong>Deceased's Middle Name:</strong> ${data.deceased_dob}</p>
                    <p><strong>Deceased's Last Name:</strong> ${data.date_of_death}</p>
                    <p><strong>Date of death:</strong> ${data.place_of_death}</p>
                    <p><strong>Date of Death:</strong> ${data.cause_of_death}</p>
                    <p><strong>Place of Death:</strong> ${data.informant_name}</p>
                    <p><strong>Cause of Death:</strong> ${data.relationship_to_deceased}</p>
                    <p><strong>Informant's Name:</strong> ${data.informant_contact}</p>
                    <p><strong>Relationship to Deceased:</strong> ${data.disposition_method}</p>
                    <p><strong>Informant's Contact Number:</strong> ${data.disposition_date}</p>
                    <p><strong>Method of Disposition:</strong> ${data.disposition_location}</p>
                    <p><strong>Date of Disposition:</strong> ${data.status}</p>
                    <p><strong>Location of Disposition:</strong> ${data.created_at}</p>
                `;
                document.getElementById('deathDetailsContent').innerHTML = deathDetailsContent; // Populate modal content
                document.getElementById('viewdeathModal').classList.remove('hidden'); // Show the modal
            } else {
                showToast('death registration not found.', 'error'); // Handle error
            }
        })
        .catch(error => console.error('Error fetching death registration details:', error));
}

// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewdeathModal').classList.add('hidden'); // Hide the modal
});





</script>
