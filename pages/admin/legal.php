<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
        <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 4h.01M6 8l6 6 6-6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>LEGAL AND ADMINISTRATIVE</h1>
        </div>
        <div class='container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg relative w-[88%]'>
        
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

            <!-- permit Registration Table -->
            <div class='w-full overflow-x-auto'> <!-- Wrapper for responsiveness -->
                <table class='w-full table-auto bg-white'>
                    <thead class='bg-gray-200'>
                        <tr>
                            <th class='px-4 py-2'>Reference Number</th>
                            <th class='px-4 py-2'>Resident Name</th> <!-- New column for userId -->
                            <th class='px-4 py-2'>Status</th>
                            <th class='px-4 py-2'>Employee Assigned</th>
                        </tr>
                    </thead>
                    <tbody id='usersTable' class='divide-y divide-gray-300'>
                        <!-- Data will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>





        </div>
    </div>
";

adminLayout($updateProfileContent);
?>
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
// Fetch the list of permit registrations for the specific employee
const fetchpermitRegistrations = () => {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    

    // Make sure to encode the search parameter for safe URL usage
    const encodedSearch = encodeURIComponent(search);

    fetch(`https://civilregistrar.lgu2.com/api/legal.php?search=${encodedSearch}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                const tableBody = document.querySelector('#usersTable');
                tableBody.innerHTML = ''; // Clear previous entries

                data.forEach(permit => {
                    const row = `
                        <tr class='border-b border-x border-gray-300'>
                            <td class='px-4 py-2 border-r border-gray-300'>${permit.reference_number}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${permit.user_name}</td> <!-- Display user name here -->
                            <td class='px-4 py-2 text-center border-r border-gray-300'>
                                <span class='${(permit.status === "verified" || permit.status === "completed") ? "bg-green-300 text-green-800" : "bg-yellow-300 text-yellow-800"} text-xs font-medium px-2.5 py-0.5 rounded'>
                                    ${permit.status}
                                </span>
                            </td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${permit.employee_id}</td>

                          
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
document.getElementById('searchInput').addEventListener('input', fetchpermitRegistrations);
document.getElementById('statusFilter').addEventListener('change', fetchpermitRegistrations);
fetchpermitRegistrations(); // Initial call to fetch data

let currentpermitId = null; // Variable to hold the current permit ID for updating status

function updateStatus(permitId) {
    currentpermitId = permitId; // Set the current permit ID
    document.getElementById('statusUpdateModal').classList.remove('hidden'); // Show the modal
}

document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value; // Get the selected value
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        // Prepare data for the update
        const updatedData = {
            id: currentpermitId,
            status: newStatus,
            employee_id: employeeId
        };

        // Send the update request
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
                showToast(data.message, 'success'); // Show success message
                fetchpermitRegistrations(); // Refresh the table
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


const deleteModal =  document.getElementById('deleteConfirmationModal')

function closedeletebutton(){
    deleteModal.classList.toggle('hidden');
}
// Close modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
      if (e.target === deleteModal) {
        closedeletebutton();
      }
});

const viewModal =  document.getElementById('viewpermitModal')

function closeViewbutton(){
    viewModal.classList.add('hidden');
}
// Close modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
      if (e.target === viewModal) {
        closeViewbutton();
      }
});

// Confirm deletion of a permit registration
function confirmDelete(permitId) {
    currentpermitId = permitId; // Set the current permit ID for deletion
    document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show delete confirmation modal
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
        body: JSON.stringify({ id: currentpermitId, employee_id: employeeId }) // Include employee ID if needed
    })
    .then(response => response.json())
    .then(data => {
        // Check for success message
        if (data.message) {
            showToast(data.message, 'error'); // Show success message
            fetchpermitRegistrations(); // Refresh the table after deletion
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


function viewpermit(permitId) {
    // Fetch the permit registration details
    fetch(`https://civilregistrar.lgu2.com/api/legal.php?id=${permitId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the modal with permit registration details
                const permitDetailsContent = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Child Name:</strong> ${data.child_first_name} ${data.child_middle_name} ${data.child_last_name}</p>
                    <p><strong>Sex:</strong> ${data.child_sex}</p>
                    <p><strong>Date of permit:</strong> ${data.child_date_of_permit}</p>
                    <p><strong>Time of permit:</strong> ${data.child_time_of_permit}</p>
                    <p><strong>Place of permit:</strong> ${data.child_place_of_permit}</p>
                    <p><strong>permit Type:</strong> ${data.child_permit_type}</p>
                    <p><strong>permit Order:</strong> ${data.child_permit_order}</p>
                    <p><strong>Father Name:</strong> ${data.father_first_name} ${data.father_middle_name} ${data.father_last_name} ${data.father_suffix}</p>
                    <p><strong>Father Nationality:</strong> ${data.father_nationality}</p>
                    <p><strong>Father Date of permit:</strong> ${data.father_date_of_permit}</p>
                    <p><strong>Mother Name:</strong> ${data.mother_first_name} ${data.mother_middle_name} ${data.mother_last_name} (née ${data.mother_maiden_name})</p>
                    <p><strong>Mother Nationality:</strong> ${data.mother_nationality}</p>
                    <p><strong>Mother Date of permit:</strong> ${data.mother_date_of_permit}</p>
                    <p><strong>Parents Married at permit:</strong> ${data.parents_married_at_permit}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Created At:</strong> ${data.created_at}</p>
                `;
                document.getElementById('permitDetailsContent').innerHTML = permitDetailsContent; // Populate modal content
                document.getElementById('viewpermitModal').classList.remove('hidden'); // Show the modal
            } else {
                showToast('permit registration not found.', 'error'); // Handle error
            }
        })
        .catch(error => console.error('Error fetching permit registration details:', error));
}

// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewpermitModal').classList.add('hidden'); // Hide the modal
});





</script>
