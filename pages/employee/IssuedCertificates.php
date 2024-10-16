<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
        <div class='bg-white p-8 rounded-lg shadow-lg w-full'>
            <h2 class='text-2xl font-bold text-center mb-6 text-gray-800'>Release Certificates</h2>
            
            <form id='issuedform' enctype='multipart/form-data'>
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
    
                <!-- Issued Type (Birth, Marriage, Death) -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='issued-type'>
                        Issued Type
                    </label>
                    <select id='issued-type' name='issued_type' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                        <option value='' disabled selected>Select issued type</option>
                        <option value='birth'>Birth</option>
                        <option value='marriage'>Marriage</option>
                        <option value='death'>Death</option>
                    </select>
                </div>
    
                <!-- Submit Button -->
                <div class='flex justify-center'>
                    <button type='button' id='confirm-Issued' class='bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300'>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>

<script>
    let residents = []; // Store residents globally

    window.onload = function() {
        // Fetch the residents data from the backend
        fetch('http://localhost/civil-registrar/api/residents.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    residents = data;
                } else {
                    console.error('Failed to load resident data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching residents:', error);
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
            alert('Please select a resident and the type of certificate.');
            return;
        }

        const formData = new FormData();
        formData.append('resident_id', residentId);
        formData.append('issued_type', issuedType);

        fetch('http://localhost/civil-registrar/api/generate_certificate.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
            } else {
                displayAndPrintCertificate(data.certificateContent);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while generating the certificate.');
        });
    });

    // Function to display and print the certificate
    function displayAndPrintCertificate(certificateContent) {
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Certificate</title>
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
    }
</script>
