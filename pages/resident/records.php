<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the home page
$homeContent = "
<div class='bg-gray-300 w-full h-[88vh] overflow-y-auto'>
    <div class='px-[8px] mb-10 max-w-screen-xl mx-auto'>  <!-- Added max-w-screen-xl to control width on large screens -->
      <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM12 8v8m4-4h-8'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>HISTORY OF REQUESTS, CERTIFICATIONS, & PERMITS</h1>
        </div>
<div id='certificate-records-container' class='bg-white rounded-lg shadow mt-4 w-[88%] mx-auto p-4'>
    <table class='min-w-full table-auto'>
        <thead class=''>
            <tr>
                <th class='border-b p-2 text-left text-gray-700'>Reference Number</th>
                <th class='border-b p-2 text-left text-gray-700'>Full Name</th>
                <th class='border-b p-2 text-left text-gray-700'>Record Type</th>
                <th class='border-b p-2 text-left text-gray-700'>Status</th>
            </tr>
        </thead>
        <tbody id='certificate-records' class='p-4'>
            <!-- Certificate records will be populated here -->
        </tbody>
    </table>
</div>

        <!-- Certificate Records Section -->
        <div class='mt-10'>

            
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

    // Fetch Certificate Records
    const fetchCertificateRecords = async () => {
        try {
            const responses = await Promise.all([ 
                fetch(`http://localhost/group69/api/birth.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/marriage.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/death.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/permit_request_api.php?residentId=${residentId}`),
                fetch(`http://localhost/group69/api/legal.php?residentId=${residentId}`)
            ]);

            const [birthRecords, marriageRecords, deathRecords, permitRecords, legalRecords] = await Promise.all(responses.map(res => {
                if (!res.ok) throw new Error('Failed to fetch some records.');
                return res.json();
            }));

            const certificateRecordsContainer = document.getElementById('certificate-records');
            certificateRecordsContainer.innerHTML = '';

            const getStatusDetails = (status) => {
                switch (status.toLowerCase()) {
                    case 'pending':
                        return {
                            class: 'bg-yellow-150 text-yellow-800',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>`
                        };
                    case 'processing':
                        return {
                            class: 'bg-blue-150 text-blue-800',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8-9h1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                                </svg>`
                        };
                    case 'completed':
                        return {
                            class: 'bg-green-150 text-green-800',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>`
                        };
                    default:
                        return {
                            class: 'bg-gray-150 text-gray-800',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 6a9 9 0 110 18 9 9 0 010-18z" />
                                </svg>`
                        };
                }
            };

            // Birth Records
            birthRecords.forEach(record => {
                const { class: statusClass, icon } = getStatusDetails(record.status);
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.reference_number}</td>
                        <td class="border-b p-2">${record.child_first_name} ${record.child_middle_name} ${record.child_last_name}</td>
                        <td class="border-b p-2">Birth</td>
                        <td class="border-b p-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded ${statusClass}">
                                ${icon}<span>${record.status}</span>
                            </span>
                        </td>
                    </tr>
                `;
            });

            // Marriage Records
            marriageRecords.forEach(record => {
                const { class: statusClass, icon } = getStatusDetails(record.status);
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.reference_number}</td>
                        <td class="border-b p-2">${record.groom_first_name} ${record.groom_middle_name} ${record.groom_last_name} & ${record.bride_first_name} ${record.bride_middle_name} ${record.bride_last_name}</td>
                        <td class="border-b p-2">Marriage</td>
                        <td class="border-b p-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded ${statusClass}">
                                ${icon}<span>${record.status}</span>
                            </span>
                        </td>
                    </tr>
                `;
            });

                        // Death Records
            deathRecords.forEach(record => {
                const { class: statusClass, icon } = getStatusDetails(record.status);
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.reference_number}</td>
                        <td class="border-b p-2">${record.deceased_first_name} ${record.deceased_middle_name} ${record.deceased_last_name}</td>
                        <td class="border-b p-2">Death</td>
                        <td class="border-b p-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded ${statusClass}">
                                ${icon}<span>${record.status}</span>
                            </span>
                        </td>
                    </tr>
                `;
            });

                    // Permit Records
            permitRecords.forEach(record => {
                const { class: statusClass, icon } = getStatusDetails(record.status);
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.reference_number}</td>
                        <td class="border-b p-2">${record.resident_name}</td>
                        <td class="border-b p-2">${record.permit_type}</td>
                        <td class="border-b p-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded ${statusClass}">
                                ${icon}<span>${record.status}</span>
                            </span>
                        </td>
                    </tr>
                `;
            });

            // Legal Records
            legalRecords.forEach(record => {
                const { class: statusClass, icon } = getStatusDetails(record.status);
                certificateRecordsContainer.innerHTML += `
                    <tr>
                        <td class="border-b p-2">${record.reference_number}</td>
                        <td class="border-b p-2">${record.applicant_name}</td>
                        <td class="border-b p-2">${record.service_name}</td>
                        <td class="border-b p-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded ${statusClass}">
                                ${icon}<span>${record.status}</span>
                            </span>
                        </td>
                    </tr>
                `;
            });
            ;


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
    fetchCertificateRecords();
});

</script>