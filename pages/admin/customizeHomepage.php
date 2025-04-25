function fetchCensusData() {
    const url = 'https://api.allorigins.win/raw?url=https://backend-api-5m5k.onrender.com/api/cencus';
    
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000); // 10-second timeout

    fetch(url, { signal: controller.signal })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(responseData => {
            const data = responseData.data;
            displayCensusData(data);
        })
        .catch(error => {
            if (error.name === 'AbortError') {
                console.error('Request timed out');
                document.getElementById('censusData').innerHTML = '<p class="text-red-500">Request timed out. Please try again later.</p>';
            } else {
                console.error('Error fetching census data:', error);
                document.getElementById('censusData').innerHTML = '<p class="text-red-500">Failed to load census data.</p>';
            }
        })
        .finally(() => clearTimeout(timeoutId));
}


function displayCensusData(data) {
    const container = document.getElementById('censusData');
    if (container) {
        container.innerHTML = ''; // Clear any existing content

        // Add overflow-x-auto to the container for horizontal scroll
        container.classList.add('overflow-x-auto');

        if (Array.isArray(data) && data.length > 0) {
            const table = document.createElement('table');
            table.classList.add('min-w-full', 'bg-white', 'border', 'border-gray-200', 'rounded-lg', 'shadow-md', 'mt-4');
            table.style.tableLayout = 'auto';  // Ensures the table width adjusts according to the content

            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            Object.keys(data[0]).forEach(key => {
                const th = document.createElement('th');
                th.classList.add('px-4', 'py-2', 'text-left', 'bg-green-500', 'font-semibold');
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
                    td.classList.add('px-4', 'py-2', 'border-t', 'border-gray-200');
                    td.textContent = cell;
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