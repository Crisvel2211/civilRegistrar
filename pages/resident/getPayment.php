<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
   <div class='flex items-center space-x-2 p-4'>
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M12 4v16m8-8H4'/>
    </svg>
    <h1 class='text-2xl font-bold text-gray-800'>ALL PAYMENTS</h1>
</div>

<div class='flex justify-between mb-4 w-[90%] mx-auto'>
    <div class='flex items-center space-x-2 w-[40%]'>
        <input type='text' id='searchInput' placeholder='Search payments...' 
               class='w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'>
    </div>
    <div class='flex items-center space-x-2'>
        <label for='statusFilter' class='text-sm font-medium text-gray-600'>Filter by Status:</label>
        <select id='statusFilter' class='px-4 py-2 border border-gray-300 rounded-lg shadow-sm'>
            <option value=''>All</option>
            <option value='paid'>Paid</option>
            <option value='unpaid'>Unpaid</option>
        </select>
    </div>
</div>

<div class='overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md w-[90%] mx-auto'>
    <table class='min-w-full table-auto'>
        <thead class='bg-blue-400'>
            <tr>
                <th class='py-3 px-6 text-left text-gray-600 font-medium'>Payment ID</th>
                <th class='py-3 px-6 text-left text-gray-600 font-medium'>Amount</th>
                <th class='py-3 px-6 text-left text-gray-600 font-medium'>Source</th>
                <th class='py-3 px-6 text-left text-gray-600 font-medium'>Description</th>
                 <th class='py-3 px-6 text-left text-gray-600 font-medium'>Name</th>
                <th class='py-3 px-6 text-left text-gray-600 font-medium'>Email</th>
                 <th class='py-3 px-6 text-left text-gray-600 font-medium'>Status</th>
                 <th class='py-3 px-6 text-left text-gray-600 font-medium'>Created At</th>
            </tr>
        </thead>
        <tbody id='payments-table' class='text-sm text-gray-600'>
            <!-- Loading Indicator -->
            <tr id='loadingRow'>
                <td colspan='4' class='py-5 px-6 text-center text-gray-500'>
                    <div class='flex justify-center items-center'>
                        <svg class='animate-spin h-6 w-6 text-blue-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                            <circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle>
                            <path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8v8H4z'></path>
                        </svg>
                        <span class='ml-2'>Loading payments...</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
";

residentLayout($updateProfileContent);
?>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    async function fetchPayments() {
        try {
            // Show loading indicator
            const loadingRow = document.getElementById('loadingRow');
            if (loadingRow) {
                loadingRow.style.display = 'table-row';
            }

            const response = await fetch('https://civilregistrar.lgu2.com/api/getAllPayments.php');
const data = await response.json();

const paymentsTable = document.getElementById('payments-table');
paymentsTable.innerHTML = ''; // Clear the table

// Hide loading indicator
if (loadingRow) {
    loadingRow.style.display = 'none';
}

// Display only the first 5 payments
data.data.slice(0, 5).forEach(payment => {
    const row = document.createElement('tr');
    row.classList.add('border-b', 'border-gray-200');

    const newPaymentID = generatePaymentID();
    const paymentSource = payment.attributes.source?.type || 'N/A';
    const amount = (payment.attributes.amount / 100).toFixed(2);
    const description = payment.attributes.description || 'No description available';
    const email = payment.attributes.billing?.email || 'No email provided';
    const name = payment.attributes.billing?.name || 'No name provided';

    row.innerHTML = `
        <td class='py-3 px-6'>${newPaymentID}</td>
        <td class='py-3 px-6'>₱${amount}</td>
        <td class='py-3 px-6 capitalize'>${paymentSource}</td>  
        <td class='py-3 px-6'>${description}</td> 
        <td class='py-3 px-6'>${name}</td> 
        <td class='py-3 px-6'>${email}</td> 
        <td class='py-3 px-6 capitalize'>${payment.attributes.status}</td>
        <td class='py-3 px-6'>${new Date(payment.attributes.created_at * 1000).toLocaleString()}</td>
    `;

    paymentsTable.appendChild(row);
});

function generatePaymentID() {
    const prefix = 'PAY';
    const randomNumber = Math.floor(1000 + Math.random() * 9000); // 4-digit number between 1000–9999
    return `${prefix}-${randomNumber}`;
}



            // Attach event listener to search input
            document.getElementById('searchInput').addEventListener('input', filterPayments);

            // Attach event listener to status filter dropdown
            document.getElementById('statusFilter').addEventListener('change', filterPayments);

        } catch (error) {
            console.error("Error fetching payments:", error);
            alert("Failed to load payments.");
        }
    }

    function filterPayments() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const statusValue = document.getElementById('statusFilter').value.toLowerCase();
    const rows = document.querySelectorAll("#payments-table tr");

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");

        if (cells.length) {
            const paymentID = cells[0]?.textContent.toLowerCase();
            const amount = cells[1]?.textContent.toLowerCase();
            const source = cells[2]?.textContent.toLowerCase();
            const description = cells[3]?.textContent.toLowerCase();
            const name = cells[4]?.textContent.toLowerCase();
            const email = cells[5]?.textContent.toLowerCase();
            const status = cells[6]?.textContent.toLowerCase();
            const createdAt = cells[7]?.textContent.toLowerCase();

            // Check if the row matches the search term and filter
            const matchesSearch = paymentID.includes(searchValue) || 
                                  amount.includes(searchValue) ||
                                  source.includes(searchValue) ||
                                  description.includes(searchValue) ||
                                  name.includes(searchValue) ||
                                  email.includes(searchValue) ||
                                  status.includes(searchValue) ||
                                  createdAt.includes(searchValue);

            const matchesStatus = statusValue ? status === statusValue : true;

            row.style.display = matchesSearch && matchesStatus ? "" : "none";
        }
    });
}


    fetchPayments(); // Load payments on page load
});

</script>
