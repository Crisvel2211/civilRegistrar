<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the home page
$homeContent = "
<div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto w-full md:mt-1 px-[8px] mb-10'>

    <!-- Announcements Section -->
    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
        <i class='fas fa-bullhorn text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Announcements</h1>
    </div>

    <!-- Announcements List -->
    <div id='announcements-container' class='mt-4 grid grid-cols-1 md:grid-cols-2 gap-4'>
        <!-- Announcements will be populated here -->
    </div>

    <!-- Monitoring Tables Section -->
    <div class='mt-10'>

        <!-- Birth Records Table -->
        <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
            <h2 class='font-bold text-gray-700 text-[21px]'>Birth Records</h2>
        </div>
        <div id='birth-records-container' class='bg-white p-4 rounded-lg shadow mt-4'>
            <table class='min-w-full'>
                <thead>
                    <tr>
                        <th class='border-b p-2 text-left text-gray-700'>Full Name</th>
                        <th class='border-b p-2 text-left text-gray-700'>Date of Birth</th>
                        <th class='border-b p-2 text-left text-gray-700'>Parents' Names</th>
                    </tr>
                </thead>
                <tbody id='birth-records'>
                    <!-- Birth records will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Marriage Records Table -->
        <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
            <h2 class='font-bold text-gray-700 text-[21px]'>Marriage Records</h2>
        </div>
        <div id='marriage-records-container' class='bg-white p-4 rounded-lg shadow mt-4'>
            <table class='min-w-full'>
                <thead>
                    <tr>
                        <th class='border-b p-2 text-left text-gray-700'>Spouse 1</th>
                        <th class='border-b p-2 text-left text-gray-700'>Spouse 2</th>
                        <th class='border-b p-2 text-left text-gray-700'>Date of Marriage</th>
                    </tr>
                </thead>
                <tbody id='marriage-records'>
                    <!-- Marriage records will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Death Records Table -->
        <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
            <h2 class='font-bold text-gray-700 text-[21px]'>Death Records</h2>
        </div>
        <div id='death-records-container' class='bg-white p-4 rounded-lg shadow mt-4'>
            <table class='min-w-full'>
                <thead>
                    <tr>
                        <th class='border-b p-2 text-left text-gray-700'>Full Name</th>
                        <th class='border-b p-2 text-left text-gray-700'>Date of Death</th>
                        <th class='border-b p-2 text-left text-gray-700'>Cause of Death</th>
                    </tr>
                </thead>
                <tbody id='death-records'>
                    <!-- Death records will be populated here -->
                </tbody>
            </table>
        </div>

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
        const role = localStorage.getItem('role');

        // Fetch Announcements
        const fetchAnnouncements = async () => {
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/announcements.php?role=${role}&userId=${residentId}`);
                if (!response.ok) throw new Error('Failed to fetch announcements.');
                
                const announcements = await response.json();
                const announcementsContainer = document.getElementById('announcements-container');
                announcementsContainer.innerHTML = '';
                
                if (announcements.length > 0) {
                    announcements.forEach(announcement => {
                        const createdAt = new Date(announcement.created_at).toLocaleString('en-US', {
                            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'Asia/Manila'
                        });

                        const announcementCard = `
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h2 class="text-xl font-semibold text-gray-700">${announcement.title}</h2>
                                <p class="text-gray-600 mt-2">${announcement.description}</p>
                                ${announcement.image ? `<img src="http://localhost/civil-registrar/api/${announcement.image}" class="mt-4 w-full" alt="Announcement Image">` : ''}
                                <p class="text-gray-500 text-sm mt-4">Posted on: ${createdAt}</p>
                            </div>
                        `;
                        announcementsContainer.innerHTML += announcementCard;
                    });
                } else {
                    announcementsContainer.innerHTML = '<p class="text-gray-600">No announcements available.</p>';
                }
            } catch (error) {
                console.error('Error fetching announcements:', error);
            }
        };

        // Fetch Birth Records
        const fetchBirthRecords = async () => {
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/birth_records.php`);
                const birthRecords = await response.json();
                const birthRecordsContainer = document.getElementById('birth-records');
                birthRecordsContainer.innerHTML = '';

                birthRecords.forEach(record => {
                    birthRecordsContainer.innerHTML += `
                        <tr>
                            <td class="border-b p-2">${record.full_name}</td>
                            <td class="border-b p-2">${new Date(record.date_of_birth).toLocaleDateString()}</td>
                            <td class="border-b p-2">${record.parents_names}</td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error fetching birth records:', error);
            }
        };

        // Fetch Marriage Records
        const fetchMarriageRecords = async () => {
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/marriage_records.php`);
                const marriageRecords = await response.json();
                const marriageRecordsContainer = document.getElementById('marriage-records');
                marriageRecordsContainer.innerHTML = '';

                marriageRecords.forEach(record => {
                    marriageRecordsContainer.innerHTML += `
                        <tr>
                            <td class="border-b p-2">${record.spouse1}</td>
                            <td class="border-b p-2">${record.spouse2}</td>
                            <td class="border-b p-2">${new Date(record.date_of_marriage).toLocaleDateString()}</td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error fetching marriage records:', error);
            }
        };

        // Fetch Death Records
        const fetchDeathRecords = async () => {
            try {
                const response = await fetch(`http://localhost/civil-registrar/api/death_records.php`);
                const deathRecords = await response.json();
                const deathRecordsContainer = document.getElementById('death-records');
                deathRecordsContainer.innerHTML = '';

                deathRecords.forEach(record => {
                    deathRecordsContainer.innerHTML += `
                        <tr>
                            <td class="border-b p-2">${record.full_name}</td>
                            <td class="border-b p-2">${new Date(record.date_of_death).toLocaleDateString()}</td>
                            <td class="border-b p-2">${record.cause_of_death}</td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error fetching death records:', error);
            }
        };

        // Check Authentication and fetch data
        function checkAuthentication() {
            const token = localStorage.getItem('token');
            if (!token) window.location.href = '../login.php';
        }

        checkAuthentication();
        fetchAnnouncements();
        fetchBirthRecords();
        fetchMarriageRecords();
        fetchDeathRecords();
    });
</script>
