<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

$updateProfileContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <!-- Main Container -->
        <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6V4zM9 11h6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>DATA INTEGRATION</h1>
        </div>

        <div class='container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg relative w-[88%]'>
            <h2 class='text-xl font-semibold text-gray-700 mb-4'>Integrate Data from Other Systems</h2>

            <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                <!-- Citizen Permit & Request Integration -->
                <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-300' onclick='showIntegration(\"citizenPermit\")'>
                    Integrate Citizen Permit & Request
                </button>

                <!-- Census Integration -->
                <button class='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-300' onclick='showIntegration(\"census\")'>
                    Integrate Census Data
                </button>

                <!-- Public Health Department Integration -->
                <button class='bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-purple-300' onclick='showIntegration(\"publicHealth\")'>
                    Integrate Public Health Data
                </button>
            </div>

            <!-- Integration Details Section -->
            <div id='integrationDetails' class='mt-6 p-4 bg-gray-100 rounded-lg shadow-inner hidden'>
                <!-- Dynamic content will be injected here -->
            </div>
            <!-- Video Section -->
        <div id='videoSection' class='p-4 flex justify-center w-full'>
            <video class='h-[200px]' autoplay loop muted>
                <source src='https://civilregistrar.lgu2.com/images/dataIntegrated.webm' type='video/mp4'>
                Your browser does not support the video tag.
            </video>
        </div>
        </div>
    </div>

    <script>
        function showIntegration(integrationType) {
            const videoSection = document.getElementById('videoSection');
            const detailsDiv = document.getElementById('integrationDetails');
            let content = '';

            // Hide video section when an integration is selected
            videoSection.classList.add('hidden');

            switch (integrationType) {
                case 'citizenPermit':
                    content = `
                        <h3 class='text-lg font-semibold text-blue-600'>Citizen Permit & Request Integration</h3>
                        <p class='mt-2 text-gray-700'>Integrate data related to citizen permits and requests seamlessly.</p>
                        <div id='citizenPermitData' class='mt-4'>
                                <!-- Fetched census data will be displayed here -->
                        </div>
                        <!-- Additional content can be added here -->
                    `;
                    break;
                case 'census':
                    content = `
                        <div id='integrationDetails' class='mt-6 p-4 bg-gray-100 rounded-lg shadow-inner hidden'>
                            <h3 class='text-lg font-semibold text-green-600'>Census Data Integration</h3>
                            <p class='mt-2 text-gray-700'>Access and integrate comprehensive census data for analysis.</p>
                            <div id='censusData' class='mt-4'>
                                <!-- Fetched census data will be displayed here -->
                            </div>
                        </div>

                    `;
                    break;
                case 'publicHealth':
                    content = `
                        <h3 class='text-lg font-semibold text-purple-600'>Public Health Data Integration</h3>
                        <p class='mt-2 text-gray-700'>Integrate public health records and statistics for better insights.</p>
                        <!-- Additional content can be added here -->
                    `;
                    break;
                default:
                    content = '<p class=\'text-gray-700\'>Invalid integration type selected.</p>';
            }

            detailsDiv.innerHTML = content;
            detailsDiv.classList.remove('hidden');
        }
    </script>
";

adminLayout($updateProfileContent);
?>
<script>
    // Request Permit Integration (Birth, Marriage, Death)
    function showIntegration(integrationType) {
        const videoSection = document.getElementById('videoSection');
        const detailsDiv = document.getElementById('integrationDetails');
        let content = '';

        videoSection.classList.add('hidden');

        switch (integrationType) {
            case 'citizenPermit':
                content = `
                    <h3 class='text-lg font-semibold text-blue-600'>Citizen Permit & Request Integration</h3>
                    <p class='mt-2 text-gray-700'>Fetching Birth, Marriage, and Death records...</p>
                    <div id='permitBirthData' class='mt-4'></div>
                    <div id='permitMarriageData' class='mt-4'></div>
                    <div id='permitDeathData' class='mt-4'></div>
                `;
                break;
            case 'census':
                content = `
                    <h3 class='text-lg font-semibold text-green-600'>Census Data Integration</h3>
                    <p class='mt-2 text-gray-700 mb-4'>Access and integrate comprehensive census data for analysis.</p>
                    <input type='text' id='searchInput' class='p-2 border border-gray-300 rounded mt-2 w-[50%]' placeholder='Search census data...' oninput='searchCensusData()'>
                    <div id='censusData' class='mt-1 w-full'></div>
                `;
                fetchCensusData();
                break;
            case 'publicHealth':
                content = `
                    <h3 class='text-lg font-semibold text-purple-600'>Public Health Data Integration</h3>
                    <p class='mt-2 text-gray-700'>Fetching Birth Records...</p>
                    <div id='healthBirthData' class='mt-4'></div>
                `;
                break;
            default:
                content = '<p class=\'text-gray-700\'>Invalid integration type selected.</p>';
        }

        detailsDiv.innerHTML = content;
        detailsDiv.classList.remove('hidden');

        if (integrationType === 'citizenPermit') {
            fetchPermitData('birth');
            fetchPermitData('marriage');
            fetchPermitData('death');
        }

        if (integrationType === 'publicHealth') {
            fetchHealthBirthData();
        }
    }

    function fetchPermitData(type) {
        const urlMap = {
            birth: 'https://civilregistrar.lgu2.com/api/integratedBirth.php',
            marriage: 'https://civilregistrar.lgu2.com/api/integratedMarriage.php',
            death: 'https://civilregistrar.lgu2.com/api/integratedDeath.php'
        };

        const containerId = `permit${capitalizeFirstLetter(type)}Data`;
        const container = document.getElementById(containerId);
        container.innerHTML = `<p class="text-gray-500">Loading ${type} data...</p>`;
        container.classList.add('overflow-x-auto');
        fetch(urlMap[type])
            .then(response => response.json())
            .then(data => {
                container.innerHTML = `<h4 class="font-semibold text-md mb-2 capitalize">${type} Records</h4>`;
                displayDynamicTable(data, container);
            })
            .catch(error => {
                console.error(`Error fetching ${type} data:`, error);
                container.innerHTML = `<p class="text-red-500">Failed to load ${type} data.</p>`;
            });
    }

    function fetchHealthBirthData() {
        const url = 'https://civilregistrar.lgu2.com/api/integratedBirth.php';
        const container = document.getElementById('healthBirthData');
        container.innerHTML = `<p class="text-gray-500">Loading birth data...</p>`;
        container.classList.add('overflow-x-auto');


        fetch(url)
            .then(response => response.json())
            .then(data => {
                container.innerHTML = `<h4 class="font-semibold text-md mb-2">Birth Records</h4>`;
                displayDynamicTable(data, container);
            })
            .catch(error => {
                console.error('Error fetching public health birth data:', error);
                container.innerHTML = `<p class="text-red-500">Failed to load birth data.</p>`;
            });
    }

    function displayDynamicTable(data, container) {
        if (!Array.isArray(data) || data.length === 0) {
            container.innerHTML += '<p class="text-gray-700">No data available.</p>';
            return;
        }

        const table = document.createElement('table');
        table.classList.add('min-w-full', 'bg-white', 'border', 'border-gray-200', 'rounded-lg', 'shadow-md', 'mt-2');

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        Object.keys(data[0]).forEach(key => {
            const th = document.createElement('th');
            th.classList.add('px-4', 'py-2', 'text-left', 'bg-gray-600', 'text-white', 'text-sm');
            th.textContent = key;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        data.forEach(row => {
            const tr = document.createElement('tr');
            Object.values(row).forEach(cell => {
                const td = document.createElement('td');
                td.classList.add('px-4', 'py-2', 'border-t', 'border-gray-200', 'text-sm');
                td.textContent = cell;
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
        table.appendChild(tbody);

        container.appendChild(table);
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    function fetchCensusData() {
    const url = 'https://civilregistrar.lgu2.com/api/fetch-census.php';

    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000);

    fetch(url, { signal: controller.signal })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            displayCensusData(data); // No longer expecting data.data, return is already a list
        })
        .catch(error => {
            const msg = error.name === 'AbortError' ? 'Request timed out. Please try again later.' : 'Failed to load census data.';
            document.getElementById('censusData').innerHTML = `<p class="text-red-500">${msg}</p>`;
        })
        .finally(() => clearTimeout(timeoutId));
}

function displayCensusData(data) {
    const container = document.getElementById('censusData');
    if (container) {
        container.innerHTML = '';
        container.classList.add('overflow-x-auto');

        if (Array.isArray(data) && data.length > 0) {
            const table = document.createElement('table');
            table.classList.add('min-w-full', 'bg-white', 'border', 'border-gray-200', 'rounded-lg', 'shadow-md', 'mt-4');
            table.style.tableLayout = 'auto';

            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            Object.keys(data[0]).forEach(key => {
                const th = document.createElement('th');
                th.classList.add('px-4', 'py-2', 'text-left', 'bg-green-500', 'font-semibold', 'text-white');
                th.textContent = key.replace(/_/g, ' ');
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            data.forEach(row => {
                const tr = document.createElement('tr');
                Object.values(row).forEach(cell => {
                    const td = document.createElement('td');
                    td.classList.add('px-4', 'py-2', 'border-t', 'border-gray-200');
                    td.textContent = cell ?? '';
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);

            container.appendChild(table);
        } else {
            container.innerHTML = '<p class="text-gray-700">No census data available.</p>';
        }
    }
}

function searchCensusData() {
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const table = document.querySelector('#censusData table');
    const rows = table ? table.querySelectorAll('tbody tr') : [];

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let rowContainsSearchTerm = false;

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(searchQuery)) {
                rowContainsSearchTerm = true;
            }
        });

        row.style.display = rowContainsSearchTerm ? '' : 'none';
    });
}

</script>
