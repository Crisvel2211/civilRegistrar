<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

$homeContent = "
<div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto'>
    <div class='flex items-center space-x-2 p-4'>
        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M3 3h18M3 3v18h18V3M12 12l6 6M12 12l-6 6'/>
        </svg>
        <h1 class='text-2xl font-bold text-gray-800'>DASHBOARD</h1>
    </div>


    <div class='grid grid-cols-1 md:grid-cols-6 gap-6 mt-5 w-[100%] mt-3 mx-auto mb-[5rem]'>
            <div class='flex flex-col justify-center items-center bg-blue-400 p-4 rounded-lg shadow'>
                <i class='fas fa-baby text-blue-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700'>Birth Total <span id='birthCount' class='font-bold'>0</span></h2>
            </div>

            <div class='flex flex-col justify-center items-center bg-red-400 p-4 rounded-lg shadow'>
                <i class='fas fa-cross text-red-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700'>Death Total <span id='deathCount' class='font-bold'>0</span></h2>
            </div>

            <div class='flex flex-col justify-center items-center bg-green-400 p-4 rounded-lg shadow'>
                <i class='fas fa-ring text-green-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700'>Marriage Total <span id='marriageCount' class='font-bold'>0</span></h2>
            </div>

        
            <div class='flex flex-col justify-center items-center bg-purple-400 p-4 rounded-lg shadow'>
                <i class='fas fa-id-card text-purple-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700'>Permit Total <span id='permitCount' class='font-bold'>0</span></h2>
            </div>

            
            <div class='flex flex-col justify-center items-center bg-teal-400 p-4 rounded-lg shadow'>
                <i class='fas fa-gavel text-teal-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700 text-center'>Legal Administrative Total <span id='legalCount' class='font-bold'>0</span></h2>
            </div>

            <div class='flex flex-col justify-center items-center bg-indigo-400 p-4 rounded-lg shadow'>
                <i class='fas fa-users text-indigo-500 text-[30px] mb-2'></i>
                <h2 class='font-semibold text-gray-700'>User Total <span id='userCount' class='font-bold'>0</span></h2>
            </div>

    </div>

<div class='flex items-center space-x-2 p-4'>
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
        <path stroke-linecap='round' stroke-linejoin='round' d='M3 17l4 4L12 13l4 4 4-4'/>
    </svg>
    <h1 class='text-2xl font-bold text-gray-800'>ANALYTICS</h1>
</div>


    <!-- Charts Section -->
    <div class='grid md:grid-cols-2 grid-cols-1 gap-4 mt-5 h-full'>
        <div class='bg-white p-4 rounded-md shadow-md h-[96%] md:flex'>
            <h2 class='font-bold text-gray-700 text-[18px] mb-4'>Services</h2>
            <canvas id='doughnutChart'></canvas>
        </div>
        <div class='bg-white p-4 rounded-md shadow-md h-[96%]  '>
            <h2 class='font-bold text-gray-700 text-[18px] mb-4'>Users</h2>
            <canvas id='barChart'></canvas>
        </div>
    </div>
</div>
</div>
";

// Call the layout function with the home page content
adminLayout($homeContent);
?>

<!-- Include Chart.js library -->
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fetchCounts = () => {
        return Promise.all([
            // Fetch birth count from the API
            fetch('https://civilregistrar.lgu2.com/api/birth.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching birth count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch marriage count from the API
            fetch('https://civilregistrar.lgu2.com/api/marriage.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching marriage count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch death count from the API
            fetch('https://civilregistrar.lgu2.com/api/death.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching death count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch user count from the API
            fetch('https://civilregistrar.lgu2.com/api/users.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching user count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            fetch('https://civilregistrar.lgu2.com/api/permit_request_api.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching user count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
            }),

            fetch('https://civilregistrar.lgu2.com/api/legal.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching user count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
            }),
        ]);
    };

    // Fetch role-based counts
    const fetchRoleCounts = () => {
        return fetch('https://civilregistrar.lgu2.com/api/users.php?roleCounts=true')
            .then(response => response.json())
            .then(data => {
                const { admin, employee, resident } = data;
                return { admin, employee, resident };
            })
            .catch(error => {
                console.error('Error fetching role counts:', error);
                return { admin: 0, employee: 0, resident: 0 };
            });
    };

    // Fetch all counts and then render the charts
    fetchCounts().then(([birthCount, marriageCount, deathCount, userCount, permitCount, legalCount]) => {
        // Update the DOM elements with the counts
        document.getElementById('birthCount').textContent = birthCount;
        document.getElementById('marriageCount').textContent = marriageCount;
        document.getElementById('deathCount').textContent = deathCount;
        document.getElementById('userCount').textContent = userCount;
        document.getElementById('permitCount').textContent = permitCount;
        document.getElementById('legalCount').textContent = legalCount; 

        // Initialize Doughnut Chart after all counts have been fetched
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Birth', 'Marriage', 'Death', 'permit', 'legal'],
                datasets: [{
                    label: 'Certificates',
                    data: [birthCount, marriageCount, deathCount, permitCount, legalCount],
                    backgroundColor: ['#60a5fa', '#34d399',  '#f87171 ', '#a78bfa', '#5eead4', '#6366f1'],
                    borderColor: ['#ffffff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    });

    // Fetch role-based counts and render the Bar Chart
    fetchRoleCounts().then(({ admin, employee, resident }) => {
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Admin', 'Employee', 'Resident'],
                datasets: [{
                    label: 'Users Count',
                    data: [admin, employee, resident],
                    backgroundColor: ['#8b5cf6', '#f472b6', '#fb923c', '#22d3ee'], // New colors

                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    
    function checkAuthentication() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '../login.php';
        }
    }

    // Call the checkAuthentication function when the page loads
    checkAuthentication();

});
</script>
