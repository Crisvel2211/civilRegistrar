<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

// Define the content for the home page
$homeContent = "
<div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto'>
    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-2 '>
        <i class='fas fa-tasks text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Total Applications</h1>
    </div>

    <div class='grid md:grid-cols-4 grid-cols-1 place-items-center px-2 gap-4 mt-[30px] '>
          <div class='bg-red-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Pending</h1>
               <i class='fas fa-hourglass-half text-[25px] text-[#d9512c]'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p class='font-bold text-[18px] text-gray-900'>23</p>
            </div>
          </div>
          <!-- Card 2 -->
          <div class='bg-blue-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Approved</h1>
              <i class='fas fa-user-check text-[25px] text-gray-500'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p class='font-bold text-[18px] text-gray-900'>223</p>
            </div>
          </div>
          <!-- Card 3 -->
          <div class='bg-red-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-around w-full items-center pt-3'>
              <h1 class='font-[700] text-[16px] text-gray-700'>Issued</h1>
              <i class='fas fa-tasks text-[25px] text-[#d9512c]'></i>
            </div>
            <div class='flex justify-center items-center w-full pt-5'>
              <p class='font-bold text-[18px] text-gray-900'>12</p>
            </div>
          </div>
          <!-- Card 4 -->
          <div class='bg-yellow-400 w-full h-[120px] rounded-[8px] cardShadow flex flex-col justify-start items-start cursor-pointer'>
            <div class='flex justify-center items-center w-full pt-5'>
              <p class='font-bold text-[18px] text-gray-900'>45</p>
              <i class='fas fa-certificate text-[25px] text-[#228f30]'></i>
            </div>
          </div>
    </div>

    <!-- Charts Section -->
    <div class='grid md:grid-cols-2 grid-cols-1 gap-4 mt-10 h-full'>
        <div class='bg-white p-4 rounded-md shadow-md h-[96%] md:flex'>
            <h2 class='font-bold text-gray-700 text-[18px] mb-4'>Doughnut Chart</h2>
            <canvas id='doughnutChart'></canvas>
        </div>
        <div class='bg-white p-4 rounded-md shadow-md  h-[96%]  '>
            <h2 class='font-bold text-gray-700 text-[18px] mb-4'>Bar Chart</h2>
            <canvas id='barChart'></canvas>
        </div>
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
    // Doughnut Chart
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Issued', 'Other'],
            datasets: [{
                label: 'Applications',
                data: [23, 223, 12, 45],
                backgroundColor: ['#d9512c', '#1d4ed8', '#d9512c', '#facc15'],
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

    // Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Approved', 'Issued'],
            datasets: [{
                label: 'Tasks',
                data: [23, 223, 12],
                backgroundColor: '#1d4ed8',
                borderColor: '#ffffff',
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
</script>
