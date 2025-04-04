<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "   
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
        <div class='flex items-center space-x-2 p-4'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M16 4h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m-4 0H8a2 2 0 01-2-2V6a2 2 0 012-2h4m-4 12h4'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>RESPONSE TO RESIDENT</h1>
    </div>



        <div class='bg-white p-8 rounded-lg shadow-lg w-[80%] mx-auto mt-3'>
        
            
            <form id='appointmentform' enctype='multipart/form-data' class='grid grid-cols-2 gap-4'>
                <!-- Resident ID (hidden input) -->
                <input type='hidden' name='resident_id' id='resident_id' value=''>

                <!-- Resident Selection (Searchable Input) -->
                <div class='mb-4 '>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='resident'>
                        Resident Name
                    </label>
                    <input type='text' id='resident-search' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' placeholder='Type to search resident' required>
                    <ul id='resident-list' class='absolute bg-white border border-gray-300 rounded-lg w-[46%] z-10 hidden mt-1'></ul>
                </div>

                <!-- Appointment Type -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-type'>
                        Response Type
                    </label>
                    <select id='appointment-type' name='appointment_type' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                        <option value='' disabled selected>Select appointment type</option>
                        <option value='birth'>Birth</option>
                        <option value='marriage'>Marriage</option>
                        <option value='death'>Death</option>
                    </select>
                </div>

                <!-- Date -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-date'>
                        Select Response Date
                    </label>
                    <input id='appointment-date' name='appointment_date' type='date' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>

                <!-- Time -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-time'>
                        Select Response Time
                    </label>
                    <input id='appointment-time' name='appointment_time' type='time' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>

                <!-- Purpose of Appointment (Full Width) -->
                <div class='mb-6 '>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='purpose'>
                        Purpose of Response
                    </label>
                    <textarea id='purpose' name='purpose' placeholder='Verification, issuance of certificate, etc.' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' rows='3' required></textarea>
                </div>

                <!-- Upload Required Documents (Full Width) -->
                <div class='mb-6 '>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='requirements'>
                        Upload Requirements (Images)
                    </label>
                    <input id='requirements' name='requirements[]' type='file' accept='image/*' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' multiple required>
                    
                </div>

                <!-- Submit Button (Full Width) -->
                <div class='flex justify-center col-span-2'>
                    <button type='button' id='confirm-appointment' class='bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 w-full'>
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>
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
    // Fetch residents data and populate the resident dropdown
    let residents = []; // Store the residents globally

    window.onload = function() {
        fetch('http://localhost/group69/api/residents.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    residents = data; // Store residents data globally
                } else {
                    console.error('Failed to load resident data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching residents:', error);
            });
    };

    // Search and display resident names or IDs
    document.getElementById('resident-search').addEventListener('input', function() {
        const input = this.value.toLowerCase();
        const residentList = document.getElementById('resident-list');
        residentList.innerHTML = ''; // Clear previous results
        residentList.classList.add('hidden'); // Hide list if no input

        if (input.length > 0) {
            const filteredResidents = residents.filter(resident => {
                // Check if input matches resident name or ID
                return resident.name.toLowerCase().includes(input) || resident.id.toString().includes(input);
            });

            filteredResidents.forEach(resident => {
                const listItem = document.createElement('li');
                listItem.textContent = `${resident.name} (ID: ${resident.id})`; // Show name and ID
                listItem.className = 'cursor-pointer hover:bg-gray-200 px-3 py-2';
                listItem.dataset.id = resident.id; // Store the ID in a data attribute

                listItem.addEventListener('click', function() {
                    document.getElementById('resident-search').value = resident.name; // Set the input value
                    document.getElementById('resident_id').value = resident.id; // Set the resident ID
                    residentList.innerHTML = ''; // Clear the list after selection
                    residentList.classList.add('hidden'); // Hide the list
                });

                residentList.appendChild(listItem);
            });

            if (filteredResidents.length > 0) {
                residentList.classList.remove('hidden'); // Show the list if there are results
            } else {
                residentList.classList.add('hidden'); // Hide if no results
            }
        } else {
            residentList.classList.add('hidden'); // Hide list if input is empty
        }
    });

    // Hide the resident list if clicking outside
    document.addEventListener('click', function(event) {
        const residentList = document.getElementById('resident-list');
        if (!residentList.contains(event.target) && event.target.id !== 'resident-search') {
            residentList.classList.add('hidden'); // Hide the list when clicking outside
        }
    });

    document.getElementById('confirm-appointment').addEventListener('click', function() {
        const form = document.getElementById('appointmentform');
        const formData = new FormData(form); // Create a FormData object

        // Send the form data to the PHP API
        fetch('http://localhost/group69/api/appointments.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showToast(data.error, 'error');
            } else {
                showToast(data.message, 'success');
                form.reset(); // Clear the form after successful submission
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while booking the appointment.', 'error');
        });
    });
</script>

