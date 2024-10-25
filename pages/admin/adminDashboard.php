<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

$homeContent = "
<div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto'>
    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-2 '>
        <i class='fas fa-tasks text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Overview</h1>
    </div>

    <div class='grid md:grid-cols-4 grid-cols-1 place-items-center px-2 gap-4 mt-[30px] '>
          <!-- Total Birth Certificates -->
          <div class='bg-red-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Total Birth Certificates</h1>
               <i class='fas fa-baby text-[25px] text-[#d9512c]'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p id='birthCount' class='font-bold text-[18px] text-gray-900'>0</p>
            </div>
          </div>
          <!-- Total Marriage Certificates -->
          <div class='bg-blue-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Total Marriage Certificates</h1>
              <i class='fas fa-heart text-[25px] text-gray-500'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p id='marriageCount'class='font-bold text-[18px] text-gray-900'>0</p>
            </div>
          </div>
          <!-- Total Death Certificates -->
          <div class='bg-red-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Total Death Certificates</h1>
              <i class='fas fa-skull-crossbones text-[25px] text-[#d9512c]'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p id='deathCount' class='font-bold text-[18px] text-gray-900'>0</p>
            </div>
          </div>
          <!-- Users Card -->
          <div class='bg-yellow-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Users</h1>
              <i class='fas fa-users text-[25px] text-[#228f30]'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p id='userCount' class='font-bold text-[18px] text-gray-900'>0</p>
            </div>
          </div>
    </div>

    <!-- Charts Section -->
    <div class='grid md:grid-cols-2 grid-cols-1 gap-4 mt-10 h-full'>
        <div class='bg-white p-4 rounded-md shadow-md h-[96%] md:flex'>
            <h2 class='font-bold text-gray-700 text-[18px] mb-4'>Certificates</h2>
            <canvas id='doughnutChart'></canvas>
        </div>
        <div class='bg-white p-4 rounded-md shadow-md  h-[96%]  '>
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
            fetch('http://localhost/civil-registrar/api/birth.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching birth count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch marriage count from the API
            fetch('http://localhost/civil-registrar/api/marriage.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching marriage count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch death count from the API
            fetch('http://localhost/civil-registrar/api/death.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching death count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                }),

            // Fetch user count from the API
            fetch('http://localhost/civil-registrar/api/users.php?count=true')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching user count:', data.error);
                        return 0;
                    }
                    return data.total || 0;
                })
        ]);
    };

    // Fetch role-based counts
    const fetchRoleCounts = () => {
        return fetch('http://localhost/civil-registrar/api/users.php?roleCounts=true')
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
    fetchCounts().then(([birthCount, marriageCount, deathCount, userCount]) => {
        // Update the DOM elements with the counts
        document.getElementById('birthCount').textContent = birthCount;
        document.getElementById('marriageCount').textContent = marriageCount;
        document.getElementById('deathCount').textContent = deathCount;
        document.getElementById('userCount').textContent = userCount; // Update user count

        // Initialize Doughnut Chart after all counts have been fetched
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Birth', 'Marriage', 'Death'],
                datasets: [{
                    label: 'Certificates',
                    data: [birthCount, marriageCount, deathCount],
                    backgroundColor: ['#d9512c', '#1d4ed8',  '#facc15'],
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
                    backgroundColor: ['#1d4ed8', '#facc15', '#d9512c'],
                    borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                    borderWidth: 2
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
