<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "   
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
        <div class='bg-white p-8 rounded-lg shadow-lg w-full'>
            <h2 class='text-2xl font-bold text-center mb-6 text-gray-800'>Book an Appointment</h2>
            
            <form id='appointmentform' enctype='multipart/form-data'>
                <!-- Resident ID (hidden input) -->
                <input type='hidden' name='resident_id' id='resident_id' value=''>
    
                <!-- Resident Selection (Searchable Input) -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='resident'>
                        Resident Name
                    </label>
                    <input type='text' id='resident-search' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' placeholder='Type to search resident' required>
                    <ul id='resident-list' class='absolute bg-white border border-gray-300 rounded-lg w-[100%] z-10 hidden'></ul>
                </div>
    
                <!-- Appointment Type (Birth, Marriage, Death) -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-type'>
                        Appointment Type
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
                        Select Date
                    </label>
                    <input id='appointment-date' name='appointment_date' type='date' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>
    
                <!-- Time -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-time'>
                        Select Time
                    </label>
                    <input id='appointment-time' name='appointment_time' type='time' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>
    
                <!-- Purpose of Appointment -->
                <div class='mb-6'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='purpose'>
                        Purpose of Appointment
                    </label>
                    <textarea id='purpose' name='purpose' placeholder='Verification, issuance of certificate, etc.' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' rows='3' required></textarea>
                </div>
    
                <!-- Upload Required Documents (Images) -->
                <div class='mb-6'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='requirements'>
                        Upload Requirements (Images)
                    </label>
                    <input id='requirements' name='requirements[]' type='file' accept='image/*' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' multiple required>
                    <p class='text-gray-500 text-sm mt-2'>You can upload images like Birth Certificates, Marriage Documents, Death Certificates, etc.</p>
                </div>
    
                <!-- Submit Button -->
                <div class='flex justify-center'>
                    <button type='button' id='confirm-appointment' class='bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300'>
                        Confirm Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>

<script>
    // Fetch residents data and populate the resident dropdown
    let residents = []; // Store the residents globally

    window.onload = function() {
        fetch('http://localhost/civil-registrar/api/residents.php')
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
        fetch('http://localhost/civil-registrar/api/appointments.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
            } else {
                alert(data.message);
                form.reset(); // Clear the form after successful submission
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while booking the appointment.');
        });
    });
</script>

