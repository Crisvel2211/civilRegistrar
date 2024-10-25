<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the home page
$homeContent = "
<div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto w-full md:mt-1 px-[8px] mb-10'>


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
residentLayout($homeContent);
?>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const residentId = localStorage.getItem('userId');
         const role = localStorage.getItem('role'); // Assume the role is stored in localStorage

const fetchAnnouncements = async () => {
    try {
        const response = await fetch(`http://localhost/civil-registrar/api/announcements.php?role=${role}&userId=${residentId}`);
        
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


        function checkAuthentication() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '../login.php';
        }
    }

    // Call the checkAuthentication function when the page loads
    checkAuthentication();

        fetchAnnouncements();
    });
</script>

