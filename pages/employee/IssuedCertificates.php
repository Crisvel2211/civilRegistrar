<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
        <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 0v4m0-4H8m4 0h4m3 6h-2a2 2 0 00-2 2v2a2 2 0 002 2h2m-6 0h-4a2 2 0 00-2 2v2a2 2 0 002 2h4'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>ISSUED CERTIFICATES AND PERMIT</h1>
        </div>

        <div class='bg-white p-8 rounded-lg shadow-lg w-[80%] mt-3 mx-auto'>
    
            
            <form id='issuedform' enctype='multipart/form-data' class='grid grid-cols-2 gap-4'>
                <!-- Resident ID (hidden input) -->
                <input type='hidden' name='resident_id' id='resident_id' value=''>

                <!-- Resident Selection (Searchable Input) -->
                <div class=''>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='resident'>
                        Resident Name
                    </label>
                    <input type='text' id='resident-search' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' placeholder='Type to search resident' required>
                    <ul id='resident-list' class='absolute bg-white border border-gray-300 rounded-lg w-[36.5%] mt-1 z-10 hidden'></ul>
                </div>

                <!-- Issued Type (Birth, Marriage, Death) -->
                <div>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='issued-type'>
                        Issued Type
                    </label>
                    <select id='issued-type' name='issued_type' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                        <option value='' disabled selected>Select issued type</option>
                        <option value='birth'>Birth</option>
                        <option value='marriage'>Marriage</option>
                        <option value='death'>Death</option>
                        <option value='burial'>Burial </option>
                        
                    </select>
                </div>

                <!-- Empty div to maintain 2-column alignment -->
                <div></div>

                <!-- Submit Button (Spanning 2 columns to center it) -->
                <div class='col-span-2 flex justify-center'>
                    <button type='button' id='confirm-Issued' class='bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-blue-300 w-full'>
                        Create
                    </button>
                </div>
            </form>


            <!-- Certificate Display Section -->
            <div id='certificate-display' class='mt-8 hidden'>
                <div>
                 
                    <div id='certificate-content' class='mb-6'>
                    
                    </div>

                    <!-- Buttons for Download and Print -->
                    <div class='flex justify-center'>
                        <button id='download-btn' class='bg-green-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300 mr-4'>
                            Download
                        </button>
                        <button id='print-btn' class='bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300'>
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

<script>

     function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? "linear-gradient(to right, #00b09b, #96c93d)" : "linear-gradient(to right, #ff5f6d, #ffc371)"
            },
            duration: 3000,
            close: true
        }).showToast();
    }
    let residents = []; // Store residents globally

    window.onload = function() {
        // Fetch the residents data from the backend
        fetch('https://civilregistrar.lgu2.com/api/residents.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    residents = data;
                } else {
                    showToast('Failed to load resident data:', 'error');
                }
            })
            .catch(error => {
                showToast('Error fetching residents:', 'error');
            });
    };

    // Resident search event handler
    document.getElementById('resident-search').addEventListener('input', function() {
        const input = this.value.toLowerCase();
        const residentList = document.getElementById('resident-list');
        residentList.innerHTML = ''; // Clear previous results
        residentList.classList.add('hidden');

        if (input.length > 0) {
            const filteredResidents = residents.filter(resident => {
                return resident.name.toLowerCase().includes(input) || resident.id.toString().includes(input);
            });

            filteredResidents.forEach(resident => {
                const listItem = document.createElement('li');
                listItem.textContent = `${resident.name} (ID: ${resident.id})`;
                listItem.className = 'cursor-pointer hover:bg-gray-200 px-3 py-2';
                listItem.dataset.id = resident.id;

                listItem.addEventListener('click', function() {
                    document.getElementById('resident-search').value = resident.name;
                    document.getElementById('resident_id').value = resident.id;
                    residentList.innerHTML = '';
                    residentList.classList.add('hidden');
                });

                residentList.appendChild(listItem);
            });

            if (filteredResidents.length > 0) {
                residentList.classList.remove('hidden');
            }
        } else {
            residentList.classList.add('hidden');
        }
    });

    // Hide resident list when clicking outside
    document.addEventListener('click', function(event) {
        const residentList = document.getElementById('resident-list');
        if (!residentList.contains(event.target) && event.target.id !== 'resident-search') {
            residentList.classList.add('hidden');
        }
    });

    // Handle the form submission to generate certificates
    document.getElementById('confirm-Issued').addEventListener('click', function() {
        const residentId = document.getElementById('resident_id').value;
        const issuedType = document.getElementById('issued-type').value;

        if (!residentId || !issuedType) {
            showToast('Please select a resident and the type of certificate.', ' error');
            return;
        }

        const formData = new FormData();
        formData.append('resident_id', residentId);
        formData.append('issued_type', issuedType);

        fetch('https://civilregistrar.lgu2.com/api/generate_certificate.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showToast(`Error: ${data.error}`,'error');
            } else {
                displayCertificate(data.certificateContent);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while generating the certificate.','error');
        });
    });

    // Function to display the certificate and show the buttons
    function displayCertificate(certificateContent) {
        const certificateDisplay = document.getElementById('certificate-display');
        const certificateContentDiv = document.getElementById('certificate-content');

        certificateContentDiv.innerHTML = certificateContent;
        certificateDisplay.classList.remove('hidden');
    }

    // Handle certificate download
    document.getElementById('download-btn').addEventListener('click', function() {
        const certificateContent = document.getElementById('certificate-content').innerHTML;
        const blob = new Blob([certificateContent], { type: 'text/html' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'certificate.html';
        link.click();
    });

    // Handle certificate print
    document.getElementById('print-btn').addEventListener('click', function() {
        const certificateContent = document.getElementById('certificate-content').innerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    .certificate {
                        width: 100%;
                        border: 1px solid #000;
                        padding: 20px;
                        text-align: center;
                        margin: auto;
                    }
                </style>
            </head>
            <body>
                <div class="certificate">
                    ${certificateContent}
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });
</script>
