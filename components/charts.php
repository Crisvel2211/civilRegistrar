<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Charts with TailwindCSS</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <div class="container mx-auto mt-5">
    <div class="grid md:grid-cols-2 grid-cols-1 gap-20 place-items-center items-center">
      <!-- Bar Chart -->
      <div class="mt-10 w-full h-[100%]">
        <canvas id="barChart"></canvas>
      </div>
      <!-- Doughnut Chart -->
      <div class="mt-10 h-[90%]">
        <canvas id="doughnutChart"></canvas>
      </div>
    </div>
  </div>

  <script>
    // Bar Chart Data and Options
    const barData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
        label: 'Sales',
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    };

    const barOptions = {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    };

    // Doughnut Chart Data and Options
    const doughnutData = {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: 'Votes',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(54, 162, 235, 0.5)',
          'rgba(255, 206, 86, 0.5)',
          'rgba(75, 192, 192, 0.5)',
          'rgba(153, 102, 255, 0.5)',
          'rgba(255, 159, 64, 0.5)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    };

    const doughnutOptions = {
      responsive: true,
    };

    // Render the charts
    const barChartCtx = document.getElementById('barChart').getContext('2d');
    const doughnutChartCtx = document.getElementById('doughnutChart').getContext('2d');

    new Chart(barChartCtx, {
      type: 'bar',
      data: barData,
      options: barOptions
    });

    new Chart(doughnutChartCtx, {
      type: 'doughnut',
      data: doughnutData,
      options: doughnutOptions
    });
  </script>

</body>
</html>
