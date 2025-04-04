<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
        <div class='container mx-auto p-6 '>
             <div class='flex items-center space-x-2 p-4 -ml-7 -mt-6'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M16 4h2a2 2 0 012 2v12a2 2 0 01-2 2h-2m-4 0H8a2 2 0 01-2-2V6a2 2 0 012-2h4m-4 12h4'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>RESPONSE TO RESIDENT</h1>
    </div>
            
            <!-- Appointments Grid -->
            <div id='appointments-grid' class='grid grid-cols-1 md:grid-cols-3 gap-6 mt-5'>
                <!-- Dynamic content will be inserted here -->
            </div>
        </div>
        
    </div>
";

residentLayout($updateProfileContent);
?>

<script>
    // Function to fetch appointments from the backend based on userId from localStorage
    async function fetchAppointments() {
        const userId = localStorage.getItem('userId'); // Get userId from localStorage

        if (!userId) {
            console.error('No userId found in localStorage');
            return; // Exit if userId is not found
        }

        try {
            const response = await fetch(`http://localhost/group69/api/appointments.php?userId=${userId}`); // Pass userId as a query parameter
            const appointments = await response.json();

            // Get the grid container
            const grid = document.getElementById('appointments-grid');

            // Clear any existing content
            grid.innerHTML = '';

            // Loop through the appointments and create HTML elements for each
            appointments.forEach(appointment => {
                // Map through the images in the requirements array
                const imagesHtml = appointment.requirements.map(requirement => 
                    `<img src="${requirement}" alt="${appointment.appointment_type} Requirements" class="w-full h-24 object-cover rounded-md mt-1">`
                ).join(''); // Join all image tags into a single string

                const appointmentCard = `
                    <div class="bg-${getColor(appointment.appointment_type)}-500 text-white rounded-md shadow-lg p-4 flex flex-col">
                        <h2 class="text-xl font-semibold mb-2 capitalize">${appointment.appointment_type}</h2>  
                        <div class="flex justify-between">
                            <p class="font-medium">Time:</p>
                            <p>${appointment.appointment_time}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-medium">Date:</p>
                            <p>${appointment.appointment_date}</p>
                        </div> 
                        <div class="mt-2">
                            <p class="font-medium">Purpose of Appointment:</p>
                            <p class="text-clip overflow-hidden ">${appointment.purpose}</p> <!-- Use the truncate class here -->
                        </div>
                        <div class="mt-2">
                            <p class="font-medium">Requirements:</p>
                            ${imagesHtml} <!-- Insert all images here -->
                        </div>
                    </div>
                `;
                grid.innerHTML += appointmentCard;
            });
        } catch (error) {
            console.error('Error fetching appointments:', error);
        }
    }

    // Helper function to assign colors based on appointment type
    function getColor(type) {
        switch(type) {
            case 'birth':
                return 'blue';
            case 'death':
                return 'green';
            case 'marriage':
                return 'purple';
            default:
                return 'gray';
        }
    }

    // Fetch appointments when the page loads
    window.onload = fetchAppointments; // Call fetchAppointments when the page loads

</script>
