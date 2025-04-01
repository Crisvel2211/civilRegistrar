<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
        <div class='container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg relative'>
        
            <!-- Search and Filter Section -->
            <div class='flex items-center justify-between mb-6'>
                <input type='text' id='searchInput' placeholder='Search by first name' class='w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4'>
                
                <select id='statusFilter' class='p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400'>
                    <option value=''>All</option>
                    <option value='pending'>Pending</option>
                    <option value='processing'>Processing</option>
                    <option value='completed'>Completed</option>
                </select>
            </div>

            <!-- death Registration Table -->
            <div class='w-full overflow-x-auto'> <!-- Wrapper for responsiveness -->
                <table class='w-full table-auto bg-white'>
                    <thead class='bg-gray-200'>
                        <tr>
                            <th class='px-4 py-2'>Reference Number</th>
                            <th class='px-4 py-2'>Resident Name</th> <!-- New column for userId -->
                            <th class='px-4 py-2'>Status</th>
                            <th class='px-4 py-2'>Details</th>
                            <th class='px-4 py-2'>Actions</th>
                        </tr>
                    </thead>
                    <tbody id='usersTable' class='divide-y divide-gray-300'>
                        <!-- Data will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>



            <!-- Status Update Modal -->
           <!-- Status Update Modal -->
            <div id='statusUpdateModal' class='fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity'>
                <div class='bg-white rounded-lg shadow-lg w-[90%] max-w-md p-6 mx-4 md:mx-0 transition-transform transform scale-100'>
                    <!-- Modal Header -->
                    <div class='flex justify-between items-center border-b pb-3 mb-4'>
                        <h2 class='text-2xl font-semibold text-gray-800'>Update Status</h2>
                        <button onclick='closeUpdatebutton()' class='text-gray-500 hover:text-gray-700 focus:outline-none'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class='mb-6'>
                        <label for='newStatusInput' class='block text-sm font-medium text-gray-700 mb-2'>Select New Status</label>
                        <select id='newStatusInput' class='w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400'>
                            <option value='pending'>Pending</option>
                            <option value='processing'>Processing</option>
                            <option value='completed'>Completed</option>
                        </select>
                    </div>

                    <!-- Modal Footer -->
                    <div class='flex justify-between space-x-4'>
                        <button id='modalCancelButton' onclick='closeUpdatebutton()' class='px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition'>
                            Cancel
                        </button>
                        <button id='modalConfirmButton' class='px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition'>
                            Update Status
                        </button>
                    </div>
                </div>
            </div>


           <!-- Delete Confirmation Modal -->
            <div id='deleteConfirmationModal' class='fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center'>
                <div class='bg-white rounded-lg shadow-lg max-w-sm w-full p-6'>
                    <div class='text-center'>
                        <h2 class='text-xl font-semibold text-gray-800 mb-4'>Confirm Deletion</h2>
                        <p class='text-gray-600 mb-6'>Are you sure you want to delete this death registration? This action cannot be undone.</p>
                    </div>
                    <div class='flex justify-between'>
                        <button id='deleteModalCancelButton' class='w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 rounded-md transition duration-300 mr-2'>Cancel</button>
                        <button id='deleteModalConfirmButton' class='w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-md transition duration-300'>Delete</button>
                    </div>
                </div>
            </div>


            <!-- View death Modal -->
            <div id='viewdeathModal' class='fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden'>
                <div class='bg-white rounded-lg shadow-lg max-w-lg w-full p-6'>
                    <!-- Modal Header -->
                    <div class='flex justify-between items-center border-b pb-3 mb-4'>
                        <h3 class='text-lg font-semibold text-gray-800'>death Registration Details</h3>
                        <button id='viewModalCloseButton' class='text-gray-500 hover:text-gray-700 focus:outline-none' onclick='closeViewbutton()'>
                            <i class='fas fa-times'></i>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div id='deathDetailsContent' class='space-y-3 text-sm text-gray-700'>
                        <!-- death details will be dynamically populated here -->
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class='mt-6 text-right border-t pt-3'>
                        <button class='px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition' onclick='closeViewbutton()'>Close</button>
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

    fetch(`http://localhost/group69/api/death.php?employee_id=${employeeId}&search=${encodedSearch}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                const tableBody = document.querySelector('#usersTable');
                tableBody.innerHTML = ''; // Clear previous entries

                data.forEach(death => {
                    console.log(death.status);
                    const row = `
                        <tr class='border-b border-x border-gray-300'>
                            <td class='px-4 py-2 border-r border-gray-300'>${death.reference_number}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${death.user_name}</td> <!-- Display user name here -->
                            <td class='px-4 py-2 text-center border-r border-gray-300'>
                                <span class='${(death.status === 'processing') ? 'bg-blue-200 text-blue-800' : (death.status === 'completed') ? 'bg-green-300 text-green-800' : (death.status === 'pending') ? 'bg-yellow-300 text-yellow-800' : 'bg-gray-200 text-gray-800'} text-xs font-medium px-2.5 py-0.5 rounded'>
                                    ${death.status}
                                </span>
                            </td>


                            <td class='px-4 py-2 text-center border-r border-gray-300'>
                                <button class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 transition duration-300' onclick='viewdeath(${death.id})'>View</button>
                            </td>
                            <td class='px-4 py-2 flex justify-around'>
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

let currentdeathId = null; // Store the current death ID


function closeUpdatebutton() {
    document.getElementById('statusUpdateModal').classList.add('hidden'); // Hide modal
}

// Update status on confirmation
document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value;
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        const updatedData = {
            id: currentdeathId,
            status: newStatus,
            employee_id: employeeId
        };

        fetch(`http://localhost/group69/api/death.php`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                fetchdeathRegistrations();
            } else {
                showToast(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => console.error('Error:', error));

        closeUpdatebutton();
        document.getElementById('newStatusInput').value = ''; // Reset input
    } else {
        showToast('Please select a status.', 'error');
    }
});

function updateStatus(deathId) {
    currentdeathId = deathId; // Set the death ID

    // Fetch the current death registration data to get the current status
    fetch(`http://localhost/group69/api/death.php?id=${deathId}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.status) {
                // Set the current status as the selected option in the modal
                document.getElementById('newStatusInput').value = data.status;
            }
        })
        .catch(error => console.error('Error:', error));

    // Show the modal
    document.getElementById('statusUpdateModal').classList.remove('hidden');
}


// Close modal on cancel button click
document.getElementById('modalCancelButton').addEventListener('click', () => {
    document.getElementById('statusUpdateModal').classList.add('hidden'); // Hide the modal
    document.getElementById('newStatusInput').value = ''; // Reset the select input
});


const statusModal =  document.getElementById('statusUpdateModal')

function closeUpdatebutton(){
    statusModal.classList.toggle('hidden');
}
// Close modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
      if (e.target === statusModal) {
        closeUpdatebutton();
      }
});


const viewModal =  document.getElementById('viewdeathModal')

function closeViewbutton(){
    viewModal.classList.add('hidden');
}
// Close modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
      if (e.target === viewModal) {
        closeViewbutton();
      }
});

// Handling the delete modal display and actions
const deleteModal = document.getElementById('deleteConfirmationModal');

function closeDeleteModal() {
    deleteModal.classList.add('hidden');
}

// Close the modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
    if (e.target === deleteModal) {
        closeDeleteModal();
    }
});

// Confirm deletion of a death registration
function confirmDelete(deathId) {
    currentdeathId = deathId; // Set the current death ID for deletion
    deleteModal.classList.remove('hidden'); // Show delete confirmation modal
}

// Handle the confirmation of deletion
document.getElementById('deleteModalConfirmButton').addEventListener('click', () => {
    const employeeId = localStorage.getItem('userId');

    // Send the delete request
    fetch(`http://localhost/group69/api/death.php`, {
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
            showToast(data.message, 'success'); // Show success message
            fetchdeathRegistrations(); // Refresh the table after deletion
        } else if (data.error) {
            showToast(data.error || 'An error occurred'); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An unexpected error occurred.', 'error'); // Handle fetch error
    });

    closeDeleteModal(); // Hide the modal after submission
});

// Close modal on cancel button click
document.getElementById('deleteModalCancelButton').addEventListener('click', () => {
    closeDeleteModal(); // Hide the modal
});


    // Open the modal and populate details
    function viewdeath(deathId) {
        fetch(`http://localhost/group69/api/death.php?id=${deathId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    const deathDetailsContent = `
                    <div class="grid grid-cols-2 gap-4">
                    <p><strong>RN:</strong> ${data.reference_number}</p>
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
                    </div>
                    `;
                    document.getElementById('deathDetailsContent').innerHTML = deathDetailsContent;
                    document.getElementById('viewdeathModal').classList.remove('hidden');
                } else {
                    showToast('death registration not found.', 'error');
                }
            })
            .catch(error => console.error('Error fetching death registration details:', error));
    }

    // Close the modal on button click
    function closeViewbutton() {
        document.getElementById('viewdeathModal').classList.add('hidden');
    }

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('viewdeathModal');
        if (e.target === modal) {
            closeViewbutton();
        }
    });


// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewdeathModal').classList.add('hidden'); // Hide the modal
});





</script>
