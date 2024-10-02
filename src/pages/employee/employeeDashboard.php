<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Define the content for the home page
$homeContent = "
 <div class='container mx-auto w-full mt-20 md:mt-1 px-[8px] mb-10'>
    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-2 '>
        <i class='fas fa-tasks text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Employee Dashboard</h1>
    </div>
   

    <!-- Table with Filtering -->
   <div class='mt-10'>
    <div class='mb-4 flex justify-between items-center w-full gap-4'>
        <div class='flex items-center gap-3'>
            <i class='fas fa-tasks text-[#93A3BC] text-2xl'></i>
            <h1 class='font-bold text-gray-800 text-xl'>Recent Task</h1>
        </div>
        <div class='flex items-center'>
            <label for='filter' class='block text-gray-700 mr-2'>Filter by Status:</label>
            <select id='filter' class='w-2/4 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500'>
                <option value='All'>All</option>
                <option value='Pending'>Pending</option>
                <option value='Approved'>Approved</option>
                <option value='Issued'>Issued</option>
            </select>
        </div>
    </div>

    <div class='overflow-x-auto'>
        <table class='min-w-full divide-y divide-gray-200 bg-white border border-gray-200 rounded-lg shadow-md'>
            <thead>
                <tr>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50'>ID</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50'>Name</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50'>Status</th>
                    <th class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50'>Category</th>
                </tr>
            </thead>
            <tbody id='taskTableBody' class='bg-white divide-y divide-gray-200'>
                <!-- Sample Data Rows -->
                <tr data-status='Pending'>
                    <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>1</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Task A</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Pending</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Category 1</td>
                </tr>
                <tr data-status='Approved'>
                    <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>2</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Task B</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Approved</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Category 2</td>
                </tr>
                <tr data-status='Issued'>
                    <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>3</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Task C</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Issued</td>
                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-600'>Category 3</td>
                </tr>
                <!-- More rows can be added here -->
            </tbody>
        </table>
    </div>
</div>

</div>
";

// Call the layout function with the home page content
employeeLayout($homeContent);
?>

<!-- Include Chart.js library -->
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Filter Table Functionality
    document.getElementById('filter').addEventListener('change', (e) => {
        const filterValue = e.target.value;
        const rows = document.querySelectorAll('#taskTableBody tr');
        rows.forEach(row => {
            if (filterValue === 'All' || row.getAttribute('data-status') === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
