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

    <!-- Certificate Records Section -->
    <div class='mt-10'>
        <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-8'>
            <i class='fas fa-certificate text-[#93A3BC] text-[25px]'></i>
            <h2 class='font-bold text-gray-700 text-[21px]'>Certificate Records</h2>
        </div>

        <div id='certificate-records-container' class='bg-white p-4 rounded-lg shadow mt-4'>
            <table class='min-w-full table-auto'>
                <thead>
                    <tr>
                        <th class='border-b p-2 text-left text-gray-700'>Full Name</th>
                        <th class='border-b p-2 text-left text-gray-700'>Record Type</th>
                        <th class='border-b p-2 text-left text-gray-700'>Status</th>
                    </tr>
                </thead>
                <tbody id='certificate-records'>
                    <!-- Certificate records will be populated here -->
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
            const response = await fetch(`http://localhost/group69/api/announcements.php?role=${role}&userId=${residentId}`);
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
                            ${announcement.image ? `<img src="http://localhost/group69/api/${announcement.image}" class="mt-4 w-full" alt="Announcement Image">` : ''}
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

    // Fetch Certificate Records
    const fetchCertificateRecords = async () => {
        try {
            const responses = await Promise.all([
                fetch(`http://localhost/group69/api/birth.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/marriage.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/death.php?residentId=${residentId}`)
            ]);

            const [birthRecords, marriageRecords, deathRecords] = await Promise.all(responses.map(res => {
                if (!res.ok) throw new Error('Failed to fetch some records.');
                return res.json();
            }));

            const certificateRecordsContainer = document.getElementById('certificate-records');
            certificateRecordsContainer.innerHTML = '';

            const getStatusColor = (status) => {
                switch (status.toLowerCase()) {
                    case 'pending':
                        return 'bg-yellow-200 text-yellow-800';
                    case 'processing':
                        return 'bg-blue-200 text-blue-800';
                    case 'completed':
                        return 'bg-green-200 text-green-800';
                    default:
                        return 'bg-gray-200 text-gray-800';
                }
            };

            birthRecords.forEach(record => {
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.child_first_name} ${record.child_middle_name} ${record.child_last_name}</td>
                        <td class="border-b p-2">Birth</td>
                        <td class="border-b p-2 text-center ${getStatusColor(record.status)}">${record.status}</td>
                    </tr>
                `;
            });

            marriageRecords.forEach(record => {
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.groom_first_name} ${record.groom_middle_name} ${record.groom_last_name} & ${record.bride_first_name} ${record.bride_middle_name} ${record.bride_last_name}</td>
                        <td class="border-b p-2">Marriage</td>
                        <td class="border-b p-2 text-center ${getStatusColor(record.status)}">${record.status}</td>
                    </tr>
                `;
            });

            deathRecords.forEach(record => {
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.deceased_first_name} ${record.deceased_middle_name} ${record.deceased_last_name}</td>
                        <td class="border-b p-2">Death</td>
                        <td class="border-b p-2 text-center ${getStatusColor(record.status)}">${record.status}</td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Error fetching certificate records:', error);
        }
    };

    // Check Authentication and fetch data
    function checkAuthentication() {
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '../login.php';
    }

    checkAuthentication();
    fetchAnnouncements();
    fetchCertificateRecords();
});
</script>
