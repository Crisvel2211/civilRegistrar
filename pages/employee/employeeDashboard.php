<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Define the content for the home page
$homeContent = "
<div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto w-full md:mt-1 px-[8px] mb-10'>

    <div class='flex items-center space-x-2 p-4'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M3 3h18M3 3v18h18V3M12 12l6 6M12 12l-6 6'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>DASHBOARD</h1>
    </div>


<div class='grid grid-cols-1 md:grid-cols-5 gap-6 mt-5 w-[90%] mt-3 mx-auto'>
    <div class='flex flex-col justify-center items-center bg-blue-400 p-4 rounded-lg shadow'>
        <i class='fas fa-baby text-blue-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Birth Total <span id='birth-count' class='font-bold'>0</span></h2>
    </div>

    <div class='flex flex-col justify-center items-center bg-red-400 p-4 rounded-lg shadow'>
        <i class='fas fa-cross text-red-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Death Total <span id='death-count' class='font-bold'>0</span></h2>
    </div>

    <div class='flex flex-col justify-center items-center bg-green-400 p-4 rounded-lg shadow'>
        <i class='fas fa-ring text-green-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Marriage Total <span id='marriage-count' class='font-bold'>0</span></h2>
    </div>

   
    <div class='flex flex-col justify-center items-center bg-purple-400 p-4 rounded-lg shadow'>
        <i class='fas fa-id-card text-purple-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700'>Permit Total <span id='permit-count' class='font-bold'>0</span></h2>
    </div>

    
    <div class='flex flex-col justify-center items-center bg-teal-400 p-4 rounded-lg shadow'>
        <i class='fas fa-gavel text-teal-500 text-[30px] mb-2'></i>
        <h2 class='font-semibold text-gray-700 text-center'>Legal Administrative Total <span id='legal-admin-count' class='font-bold'>0</span></h2>
    </div>
</div>


    <div class='flex items-center space-x-2 p-4 mt-[5rem]'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-9 4h4m-2-2v4m-1 10h6'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>ANNOUNCEMENT</h1>
    </div>


    <!-- Announcements List -->
    <div id='announcements-container' class='mt-4 grid grid-cols-1 md:grid-cols-2 gap-4  w-[90%] mt-3 mx-auto'>
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
        const response = await fetch(`http://localhost/group69/api/announcements.php?role=${role}&userId=${employeeId}`);
        
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
                        ${announcement.image ? `<img src="http://localhost/group69/api/${announcement.image}" class="mt-4 w-full" alt="Announcement Image">` : ''}
                          <p class="text-gray-500 text-sm mt-4">Posted on: ${createdAt}</p>
                    </div>
                `;
                // Append the card to the container
                announcementsContainer.innerHTML += announcementCard;
            });
        } else {
            announcementsContainer.innerHTML = `
                <div class="p-4 flex justify-center w-full">
                    <video class="h-[200px]" autoplay loop muted>
                        <source src="http://localhost/group69/images/announcements.webm" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching announcements:', error);
    }
};


        // Function to fetch death count
        const fetchDeathCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/group69/api/death.php?get_employee_counts=true&employee_id=${employeeId}`);
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
                const response = await fetch(`http://localhost/group69/api/birth.php?get_employee_counts=true&employee_id=${employeeId}`);
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
                const response = await fetch(`http://localhost/group69/api/marriage.php?get_employee_counts=true&employee_id=${employeeId}`);
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


        const fetchPermitCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/group69/api/permit_request_api.php?get_employee_counts=true&employee_id=${employeeId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Check if data is an object and contains total_certificates
                if (data && typeof data === 'object' && 'total_certificates' in data) {
                    // Update the death count in the HTML
                    document.getElementById('permit-count').innerText = data.total_certificates || 0;
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error fetching birth count:', error);
                document.getElementById('permit-count').innerText = 'Error';
            }
        };

        const fetchLegalCount = async () => {
            const employeeId = localStorage.getItem('userId');
            try {
                const response = await fetch(`http://localhost/group69/api/legal.php?get_employee_counts=true&employee_id=${employeeId}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Check if data is an object and contains total_certificates
                if (data && typeof data === 'object' && 'total_certificates' in data) {
                    // Update the death count in the HTML
                    document.getElementById('legal-admin-count').innerText = data.total_certificates || 0;
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error fetching birth count:', error);
                document.getElementById('legal-admin-count').innerText = 'Error';
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
        fetchPermitCount();
        fetchLegalCount();
        fetchAnnouncements();
    });
</script>

