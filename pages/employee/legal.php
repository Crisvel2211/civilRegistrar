<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
        <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 4h.01M6 8l6 6 6-6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>LEGAL AND ADMINISTRATIVE</h1>
        </div>

        <div class='container mx-auto p-6 bg-white rounded-lg shadow-lg relative w-[88%] mt-[3rem]'>
        
            <!-- Search and Filter Section -->
             <div class='flex items-center justify-between mb-6 gap-2'>
                <input type='text' id='searchInput' placeholder='Search by Reference Number' class='w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4'>

                <input type='text' id='dateFilter' placeholder='Select date' class='p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400'>

                
                <select id='statusFilter' class='p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400'>
                    <option value=''>All</option>
                    <option value='pending'>Pending</option>
                    <option value='processing'>Processing</option>
                    <option value='completed'>Completed</option>
                </select>
            </div>

            <!-- legal Registration Table -->
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
                        <p class='text-gray-600 mb-6'>Are you sure you want to delete this legal registration? This action cannot be undone.</p>
                    </div>
                    <div class='flex justify-between'>
                        <button id='deleteModalCancelButton' class='w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 rounded-md transition duration-300 mr-2'>Cancel</button>
                        <button id='deleteModalConfirmButton' class='w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-md transition duration-300'>Delete</button>
                    </div>
                </div>
            </div>


            <!-- View legal Modal -->
            <div id='viewlegalModal' class='fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden'>
                <div class='bg-white rounded-lg shadow-lg max-w-lg w-full p-6'>
                    <!-- Modal Header -->
                    <div class='flex justify-between items-center border-b pb-3 mb-4'>
                        <h3 class='text-lg font-semibold text-gray-800'>Legal And Administrative Registration Details</h3>
                        <button id='viewModalCloseButton' class='text-gray-500 hover:text-gray-700 focus:outline-none' onclick='closeViewbutton()'>
                            <i class='fas fa-times'></i>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div id='legalDetailsContent' class='space-y-3 text-sm text-gray-700'>
                        <!-- legal details will be dynamically populated here -->
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
// Fetch the list of legal registrations for the specific employee
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#dateFilter", {
    dateFormat: "Y-m-d", // Only the date (e.g., 2025-04-15)
    allowInput: true
});


    // Hook filters
    document.getElementById('searchInput').addEventListener('input', fetchlegalRegistrations);
    document.getElementById('statusFilter').addEventListener('change', fetchlegalRegistrations);
    document.getElementById('dateFilter').addEventListener('change', fetchlegalRegistrations);

    fetchlegalRegistrations(); // Initial load
});

const fetchlegalRegistrations = () => {
    const search = document.getElementById('searchInput').value.trim();
    const status = document.getElementById('statusFilter').value;
    const createdAt = document.getElementById('dateFilter').value; // <-- grab date
    const employeeId = localStorage.getItem('userId');

    const params = new URLSearchParams();

    if (employeeId) params.append('employee_id', employeeId);
    if (search) params.append('search', encodeURIComponent(search));
    if (status) params.append('status', status);
    if (createdAt) params.append('created_at', createdAt); // <-- add to query

    fetch(`https://civilregistrar.lgu2.com/api/legal.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#usersTable');
            tableBody.innerHTML = '';

            if (!Array.isArray(data)) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4">No records found.</td></tr>`;
                return;
            }

            data.forEach(legal => {
                const row = `
                    <tr class='border-b border-x border-gray-300'>
                        <td class='px-4 py-2 border-r border-gray-300'>${legal.reference_number}</td>
                        <td class='px-4 py-2 text-center border-r border-gray-300'>${legal.user_name}</td>
                        <td class='px-4 py-2 text-center border-r border-gray-300'>
                            <span class='${getStatusClass(legal.status)} text-xs font-medium px-2.5 py-0.5 rounded'>
                                ${legal.status}
                            </span>
                        </td>
                        <td class='px-4 py-2 text-center border-r border-gray-300'>
                            <button class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 transition duration-300' onclick='viewlegal(${legal.id})'>View</button>
                        </td>
                        <td class='px-4 py-2 flex justify-around'>
                            <button class='text-blue-500 hover:text-blue-400' onclick='updateStatus(${legal.id})'>
                                <i class='fas fa-sync-alt'></i>
                            </button>
                            <button class='text-red-500 hover:text-red-400' onclick='confirmDelete(${legal.id})'>
                                <i class='fas fa-trash'></i>
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error:', error));
};

// Helper to style status
function getStatusClass(status) {
    if (status === 'processing') return 'bg-blue-200 text-blue-800';
    if (status === 'completed') return 'bg-green-300 text-green-800';
    if (status === 'pending') return 'bg-yellow-300 text-yellow-800';
    return 'bg-gray-200 text-gray-800';
}


let currentlegalId = null; // Store the current legal ID


function closeUpdatebutton() {
    document.getElementById('statusUpdateModal').classList.add('hidden'); // Hide modal
}

// Update status on confirmation
document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value;
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        const updatedData = {
            id: currentlegalId,
            status: newStatus,
            employee_id: employeeId
        };

        fetch(`https://civilregistrar.lgu2.com/api/legal.php`, {
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
                fetchlegalRegistrations();
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

function updateStatus(legalId) {
    currentlegalId = legalId; // Set the legal ID

    // Fetch the current legal registration data to get the current status
    fetch(`https://civilregistrar.lgu2.com/api/legal.php?id=${legalId}`)
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


const viewModal =  document.getElementById('viewlegalModal')

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

// Confirm deletion of a legal registration
function confirmDelete(legalId) {
    currentlegalId = legalId; // Set the current legal ID for deletion
    deleteModal.classList.remove('hidden'); // Show delete confirmation modal
}

// Handle the confirmation of deletion
document.getElementById('deleteModalConfirmButton').addEventListener('click', () => {
    const employeeId = localStorage.getItem('userId');

    // Send the delete request
    fetch(`https://civilregistrar.lgu2.com/api/legal.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: currentlegalId, employee_id: employeeId }) // Include employee ID if needed
    })
    .then(response => response.json())
    .then(data => {
        // Check for success message
        if (data.message) {
            showToast(data.message, 'success'); // Show success message
            fetchlegalRegistrations(); // Refresh the table after deletion
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
    function viewlegal(legalId) {
        fetch(`https://civilregistrar.lgu2.com/api/legal.php?id=${legalId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    const legalDetailsContent = `
                    <div class="grid grid-cols-2 gap-4">
                    <p><strong>Case Number:</strong> ${data.case_reference_no}</p>
                    <p><strong>Services Name:</strong> ${data.service_name}</p>
                    <p><strong>Applicant Name:</strong> ${data.applicant_name}</p>
                    <p><strong>Applicant Contact:</strong> ${data.applicant_contact}</p>
                    <p><strong>Applicant Address:</strong> ${data.applicant_address}</p>
                    <p><strong>Reason For Change:</strong> ${data.reason_for_change}</p>
                    <p><strong>Reference Number:</strong> ${data.reason_for_change}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Created At</strong> ${data.created_at}</p>
                    </div>
                    `;
                    document.getElementById('legalDetailsContent').innerHTML = legalDetailsContent;
                    document.getElementById('viewlegalModal').classList.remove('hidden');
                } else {
                    showToast('legal registration not found.', 'error');
                }
            })
            .catch(error => console.error('Error fetching legal registration details:', error));
    }

    // Close the modal on button click
    function closeViewbutton() {
        document.getElementById('viewlegalModal').classList.add('hidden');
    }

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('viewlegalModal');
        if (e.target === modal) {
            closeViewbutton();
        }
    });


// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewlegalModal').classList.add('hidden'); // Hide the modal
});





</script>
