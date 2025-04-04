<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
         <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M3 12h18M12 5l-3 3m3-3l3 3m0 9H6M9 17h6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>MARRIAGE RECORDS</h1>
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

            <!-- Marriage Registration Table -->
           <div class='w-full overflow-x-auto'>
                <table class='w-full table-auto bg-white'>
                    <thead class='bg-gray-200'>
                        <tr>
                            <th class='px-4 py-2'>Reference Number</th>
                            <th class='px-4 py-2'>Resident Name</th> 
                            <th class='px-4 py-2'>Status</th>
                            <th class='px-4 py-2'>Employee Assigned</th>
                            
                        </tr>
                    </thead>
                    <tbody id='usersTable' class='divide-y divide-gray-300'>
                        <!-- Data will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>


            <!-- Status Update Modal -->
            <div id='statusUpdateModal' class='items-center justify-center h-auto z-50 hidden absolute md:top-[8rem] md:left-[20rem] md:w-[68%] top-[18rem] left-[1rem] w-full'>
                <div class='bg-white p-5 rounded shadow-lg md:w-[40%] w-[90%]'>
                    <h2 class='text-lg font-semibold mb-4'>Update Status</h2>
                    <select id='newStatusInput' class='w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4'>
                        <option value=''>Select Status</option>
                        <option value='pending'>Pending</option>
                        <option value='processing'>Processing</option>
                        <option value='verified'>Verified</option>
                        <option value='completed'>Completed</option>
                    </select>
                    <div class='flex justify-between'>
                        <button id='modalCancelButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Cancel</button>
                        <button id='modalConfirmButton' class='bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-400 ml-2'>Confirm</button>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id='deleteConfirmationModal' class='items-center justify-center h-auto z-50 hidden absolute md:top-[8rem] md:left-[20rem] md:w-[68%] top-[18rem] left-[1rem] w-full'>
                <div class='bg-white p-5 rounded shadow-lg md:w-[40%] w-[90%]'>
                    <h2 class='text-lg font-semibold mb-4'>Delete Confirmation</h2>
                    <p>Are you sure you want to delete this marriage registration?</p>
                    <div class='flex justify-between mt-2'>
                        <button id='deleteModalCancelButton' class='bg-gray-300 text-gray-800 px-4 py-1 rounded hover:bg-gray-200'>Cancel</button>
                        <button id='deleteModalConfirmButton' class='bg-red-500 text-white px-4 py-1 rounded hover:bg-red-400 ml-2'>Delete</button>
                    </div>
                </div>
            </div>

            <!-- View marriage Registration Modal -->
            <div id='viewmarriageModal' class='items-center justify-center h-auto z-50 hidden absolute md:-top-9 md:left-[15rem] top-[18rem] left-[1rem] md:w-[76%] w-full'>
                <div class='bg-white p-5 rounded shadow-lg md:w-[60%] w-[90%]'>
                    <h2 class='text-lg font-semibold mb-4'>Marriage Registration Details</h2>
                    <div id='marriageDetailsContent' class='mb-4'>
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

adminLayout($updateProfileContent);
?>
<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
// Fetch the list of marriage registrations for the specific employee
const fetchmarriageRegistrations = () => {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    
    // Make sure to encode the search parameter for safe URL usage
    const encodedSearch = encodeURIComponent(search);

    fetch(`http://localhost/group69/api/marriage.php?search=${encodedSearch}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                const tableBody = document.querySelector('#usersTable');
                tableBody.innerHTML = ''; // Clear previous entries

                data.forEach(marriage => {
                    const row = `
                        <tr class='border-b border-x border-gray-300'> 
                            <td class='px-4 py-2 border-r border-gray-300'>${marriage.reference_number}</td>
                            <td class='px-4 py-2 text-center border-r border-gray-300'>${marriage.user_name}</td> <!-- Display user name here -->
                            <td class='px-4 py-2 text-center border-r border-gray-300'>
                                <span class='${(marriage.status === "verified" || marriage.status === "completed") ? "bg-green-300 text-green-800" : "bg-yellow-300 text-yellow-800"} text-xs font-medium px-2.5 py-0.5 rounded'>
                                    ${marriage.status}
                                </span>
                            </td>
                             <td class='px-4 py-2 text-center border-r border-gray-300'>${marriage.employee_id}</td>
                           
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
document.getElementById('searchInput').addEventListener('input', fetchmarriageRegistrations);
document.getElementById('statusFilter').addEventListener('change', fetchmarriageRegistrations);
fetchmarriageRegistrations(); // Initial call to fetch data

let currentmarriageId = null; // Variable to hold the current marriage ID for updating status

function updateStatus(marriageId) {
    currentmarriageId = marriageId; // Set the current marriage ID
    document.getElementById('statusUpdateModal').classList.remove('hidden'); // Show the modal
}

document.getElementById('modalConfirmButton').addEventListener('click', () => {
    const newStatus = document.getElementById('newStatusInput').value; // Get the selected value
    const employeeId = localStorage.getItem('userId');

    if (newStatus) {
        // Prepare data for the update
        const updatedData = {
            id: currentmarriageId,
            status: newStatus,
            employee_id: employeeId
        };

        // Send the update request
        fetch(`http://localhost/group69/api/marriage.php`, {
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
                fetchmarriageRegistrations(); // Refresh the table
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

const viewModal =  document.getElementById('viewmarriageModal')

function closeViewbutton(){
    viewModal.classList.add('hidden');
}
// Close modal when clicking outside the modal panel
window.addEventListener('click', (e) => {
      if (e.target === viewModal) {
        closeViewbutton();
      }
});
// Confirm deletion of a marriage registration
function confirmDelete(marriageId) {
    currentmarriageId = marriageId; // Set the current marriage ID for deletion
    document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show delete confirmation modal
}

// Handle the confirmation of deletion
document.getElementById('deleteModalConfirmButton').addEventListener('click', () => {
    const employeeId = localStorage.getItem('userId');

    // Send the delete request
    fetch(`http://localhost/group69/api/marriage.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: currentmarriageId, employee_id: employeeId }) // Include employee ID if needed
    })
    .then(response => response.json())
    .then(data => {
        // Check for success message
        if (data.message) {
            showToast(data.message, 'error'); // Show success message
            fetchmarriageRegistrations(); // Refresh the table after deletion
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


function viewmarriage(marriageId) {
    // Fetch the marriage registration details
    fetch(`http://localhost/group69/api/marriage.php?id=${marriageId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the modal with marriage registration details
                const marriageDetailsContent = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Groom's FullName:</strong> ${data.groom_first_name} ${data.groom_middle_name} ${data.groom_last_name}</p>
                    <p><strong>Groom's Suffix (if applicable):</strong> ${data.groom_suffix}</p>
                    <p><strong>bride FullName:</strong> ${data.bride_first_name} ${data.bride_middle_name} ${data.bride_last_name} </p>
                    <p><strong>Bride's Maiden Name (if applicable):</strong> ${data.bride_maiden_name}</p>
                    <p><strong>Bride's Suffix (if applicable):</strong> ${data.bride_suffix}</p>
                    <p><strong>Date of Birth of Groom:</strong> ${data.groom_dob}</p>
                    <p><strong>Date of Birth of Bride:</strong> ${data.bride_dob}</p>
                    <p><strong>Place of Birth of Groom:</strong> ${data.groom_birth_place}</p>
                    <p><strong>Place of Birth of Bride:</strong> ${data.bride_birth_place}</p>
                    <p><strong>Groom’s Civil Status:</strong> ${data.groom_civil_status}</p>
                    <p><strong>Bride Civil Status:</strong> ${data.bride_civil_status}</p>
                    <p><strong>Nationality of Groom:</strong> ${data.groom_nationality}</p>
                    <p><strong>Nationality of Bride</strong> ${data.bride_nationality}</p>
                    <p><strong>Full Name of Groom's Father:</strong> ${data.groom_father_name}</p>
                    <p><strong>Full Name of Groom's Mother:</strong> ${data.groom_mother_name}</p>
                    <p><strong>Full Name of Bride's Father:</strong> ${data.bride_father_name}</p>
                    <p><strong>Full Name of Bride's Mother:</strong> ${data.bride_mother_name}</p>
                    <p><strong>Marriage Date:</strong> ${data.marriage_date}</p>
                    <p><strong>Marriage Place:</strong> ${data.marriage_place}</p>
                    <p><strong>Groom Witness:</strong> ${data.groom_witness}</p>
                    <p><strong>Bride Witness:</strong> ${data.bride_witness}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    <p><strong>Created At:</strong> ${data.created_at}</p>
                `;
                document.getElementById('marriageDetailsContent').innerHTML = marriageDetailsContent; // Populate modal content
                document.getElementById('viewmarriageModal').classList.remove('hidden'); // Show the modal
            } else {
                showToast('marriage registration not found.', 'error'); // Handle error
            }
        })
        .catch(error => console.error('Error fetching marriage registration details:', error));
}

// Close modal on button click
document.getElementById('viewModalCloseButton').addEventListener('click', () => {
    document.getElementById('viewmarriageModal').classList.add('hidden'); // Hide the modal
});





</script>
