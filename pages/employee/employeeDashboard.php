<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Define the content for the home page
$homeContent = "
<div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto w-full md:mt-1 px-[8px] mb-10'>

    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-2 '>
        <i class='fas fa-tasks text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Overview</h1>
    </div>

    <div class='grid grid-cols-1 md:grid-cols-4 gap-6 mt-5'>
      <div class='flex flex-col justify-center items-center bg-gray-100 p-4 rounded-lg shadow'>
         <i class='fas fa-baby text-blue-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Birth Total <span id='birth-count' class='font-bold'>0</span></h2>
      </div>
      
      <div class='flex flex-col justify-center items-center bg-gray-100 p-4 rounded-lg shadow'>
         <i class='fas fa-cross text-red-500 text-[30px] mb-2'></i>
         <h2 class='font-semibold text-gray-700'>Death Total <span id='death-count' class='font-bold'>0</span></h2>
      </div>
      
      <div class='flex flex-col justify-center items-center bg-gray-100 p-4 rounded-lg shadow'>
         <i class='fas fa-ring text-green-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Marriage Total <span id='marriage-count' class='font-bold'>0</span></h2>
      </div>
      
      <div class='flex flex-col justify-center items-center bg-gray-100 p-4 rounded-lg shadow'>
         <i class='fas fa-calendar-check text-yellow-500 text-[30px] mb-2'></i>
         <h2 class='font-semibold text-gray-700'>Appointment Total</h2>
      </div>
    </div>

    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
        <i class='fas fa-bullhorn text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Announcements</h1>
    </div>

    <!-- Announcements List -->
    <div id='announcements-container' class='mt-4 grid grid-cols-1 md:grid-cols-2 gap-4'>
        <!-- Announcements will be populated here -->
    </div>
 </div>
</div>
";

// Call the layout function with the home page content
employeeLayout($homeContent);
?>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const employeeId = localStorage.getItem('userId');
const role = localStorage.getItem('role'); // Assume the role is stored in localStorage

const fetchAnnouncements = async () => {
    try {
        const response = await fetch(`http://localhost/civil-registrar/api/announcements.php?role=${role}&userId=${employeeId}`);
        
        // Check if response is OK
        if (!response.ok) {
            throw new Error('Failed to fetch announcements.');
        }

        const announcements = await response.json();
        const announcementsContainer = document.getElementById('announcements-container');
        
        announcementsContainer.innerHTML = ''; // Clear existing announcements

        // Check if announcements are available
        if (announcements.length > 0) {
            announcements.forEach(announcement => {
                 // Format the created_at date
                 const createdAt = new Date(announcement.created_at).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true, // For AM/PM format
                    timeZone: 'Asia/Manila' // Philippines Time Zone
                });

                // Create an announcement card for each item
                const announcementCard = `
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h2 class="text-xl font-semibold text-gray-700">${announcement.title}</h2>
                        <p class="text-gray-600 mt-2">${announcement.description}</p>
                        ${announcement.image ? `<img src="http://localhost/civil-registrar/api/${announcement.image}" class="mt-4 w-full" alt="Announcement Image">` : ''}
                          <p class="text-gray-500 text-sm mt-4">Posted on: ${createdAt}</p>
                    </div>
                `;
                // Append the card to the container
                announcementsContainer.innerHTML += announcementCard;
            });
        } else {
            // If no announcements, display a message
            announcementsContainer.innerHTML = '<p class="text-gray-600">No announcements available.</p>';
        }
    } catch (error) {
        console.error('Error fetching announcements:', error);
    }
};


        // Function to fetch death count
        const fetchDeathCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/death.php?get_employee_counts=true&employee_id=${employeeId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Check if data is an object and contains total_certificates
                if (data && typeof data === 'object' && 'total_certificates' in data) {
                    // Update the death count in the HTML
                    document.getElementById('death-count').innerText = data.total_certificates || 0;
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error fetching death count:', error);
                document.getElementById('death-count').innerText = 'Error';
            }
        };

        //birthCount

        const fetchBirthCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/birth.php?get_employee_counts=true&employee_id=${employeeId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Check if data is an object and contains total_certificates
                if (data && typeof data === 'object' && 'total_certificates' in data) {
                    // Update the death count in the HTML
                    document.getElementById('birth-count').innerText = data.total_certificates || 0;
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error fetching birth count:', error);
                document.getElementById('birth-count').innerText = 'Error';
            }
        };


        //birthCount

        const fetchMarriageCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/marriage.php?get_employee_counts=true&employee_id=${employeeId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Check if data is an object and contains total_certificates
                if (data && typeof data === 'object' && 'total_certificates' in data) {
                    // Update the death count in the HTML
                    document.getElementById('marriage-count').innerText = data.total_certificates || 0;
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error fetching birth count:', error);
                document.getElementById('marriage-count').innerText = 'Error';
            }
        };

        function checkAuthentication() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '../login.php';
        }
    }

    // Call the checkAuthentication function when the page loads
    checkAuthentication();

        // Call the function to fetch death count
        fetchBirthCount();
        fetchDeathCount();
        fetchMarriageCount();
        fetchAnnouncements();
    });
</script>

