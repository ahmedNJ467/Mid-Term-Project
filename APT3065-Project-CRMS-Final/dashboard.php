<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMINISTRATOR</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-200 font-sans overflow-x-hidden">

  <!-- Top Navigation Bar -->
  <div class="fixed top-0 right-0 left-64 h-16 bg-white shadow flex items-center justify-end px-6 z-10">
    <!-- Admin Profile Section -->
    <div class="flex items-center">
      <span class="text-gray-800 text-sm mr-4">Welcome, Admin!</span>
      <img src="images/profile.png" alt="Admin Profile" class="h-10 w-10 rounded-full border-2 border-gray-300">
    </div>
  </div>

  <!-- Redesigned Sidebar -->
  <div class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white p-5">
    <!-- Logo Placeholder -->
    <div class="flex justify-center mb-6">
      <img src="images/logo.png" alt="Logo" class="h-12">
    </div>

    <!------------------------------ SIDEBAR ------------- -->
    <!-- Navigation Links -->
    <nav class="space-y-4">
      <a href="dashboard.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
      <!-- Fleet Management Menu Trigger with Arrow and Symbol -->
      <div id="fleet-management-trigger" class="flex justify-between items-center hover:bg-gray-700 p-2 rounded cursor-pointer">
        <div class="flex items-center">
          <i class="fas fa-car-alt mr-2"></i> <!-- Fleet Management Icon -->
          <span>Fleet Management</span>
        </div>
        <i class="fas fa-chevron-down"></i>
      </div>

      <!-- Fleet Management Sliding Menu (initially hidden) -->
      <div id="fleet-management-menu" class="hidden ml-4 space-y-2">
        <a href="adminvehicle.php" class="flex items-center hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-car mr-2"></i> All Vehicles
        </a>
        <a href="onrental.php" class="flex items-center hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-road mr-2"></i> On Rental
        </a>
        <!-- Maintenance Link -->
        <a href="maintenance.php" class="flex items-center hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-tools mr-2"></i> Maintenance
        </a>
      </div>


      <a href="adminusers.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded">
        <i class="fas fa-users"></i><span>Users</span>
      </a>
      <a href="adminbook.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded">
        <i class="fas fa-book-open"></i><span>Booking Request</span>
      </a>
      <a href="adminfeedback.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded">
        <i class="fas fa-comment-dots"></i><span>Feedbacks</span>
      </a>
      <a href="index.php" class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded">
        <i class="fas fa-sign-out-alt"></i><span>Log out</span>
      </a>
    </nav>
  </div>

  <!------------------------------ SIDEBAR ------------- -->




  <!-- Main Content -->
  <div class="pt-20 pl-72 pr-10 pb-4 overflow-auto">
    <!-- Dashboard Header -->
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 ml-4">Dashboard</h1>


    <div class="container mx-auto mt-8 flex gap-10">
      <!-- Fleet Status Card -->
      <div class="bg-white shadow-md rounded-lg p-4 w-full lg:w-1/2 xl:w-2/4 ml-2">
        <h2 class="text-xl font-bold mb-1">Vehicles</h2>
        <div class="flex">
          <div class="w-2/4 flex flex-col justify-center">
            <!-- Donut Chart Container -->
            <canvas id="fleetStatusChart" width="400" height="350"></canvas>
          </div>



          <div class="ml-20 mb-12 flex flex-col justify-center h-lower">
            <!-- Status Symbols and Counts -->
            <div class="space-y-4">
              <div class="flex flex-col items-start">
                <span class="text-gray-500 mb-1">Available</span>
                <div class="flex items-center">
                  <i class="fas fa-car text-blue-500 mr-2"></i>
                  <span class="available-count">Loading...</span>
                </div>
              </div>
              <div class="flex flex-col items-start">
                <span class="text-gray-500 mb-1">On Rental</span>
                <div class="flex items-center">
                  <i class="fas fa-road text-red-500 mr-2"></i>
                  <span class="on-rental-count">Loading...</span>
                </div>
              </div>
              <div class="flex flex-col items-start">
                <span class="text-gray-500 mb-1">In Maintenance</span>
                <div class="flex items-center">
                  <i class="fas fa-tools text-yellow-500 mr-2"></i>
                  <span class="in-maintenance-count">Loading...</span>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>



      <!-- Users Card -->
      <div class="bg-white p-5 rounded-lg shadow-md h-1/2 w-1/4">
        <h2 class="text-xl font-bold mb-8">Users</h2>
        <div class="space-y-8">
          <div class="flex justify-between">
            <span class="text-gray-600">Total Users</span>
            <span id="total-users" class="font-semibold text-gray-800">Loading...</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Active Rental</span>
            <span id="approved-bookings" class="font-semibold text-gray-800">Loading...</span>
          </div>
        </div>
      </div>
      <!-- Booking Status Card -->
      <div class="bg-white p-5 rounded-lg shadow-md h-1/2 w-1/4">
        <h2 class="text-xl font-bold mb-8">Bookings</h2>
        <div class="space-y-8">
          <div class="flex justify-between">
            <span class="text-gray-600">Active</span>
            <span id="active-bookings" class="font-semibold text-gray-800">Loading...</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Completed</span>
            <span id="completed-bookings" class="font-semibold text-gray-800">Loading...</span>
          </div>
        </div>
      </div>


    </div>





    <div class="flex gap-5 mt-5">
      <!-- Monthly Bookings Chart Card -->
      <div class="bg-white shadow-md rounded-lg p-4 flex-1">
        <h2 class="text-xl font-bold mb-3">Monthly Bookings</h2>
        <div class="p-4">
          <canvas id="monthlyBookingsChart" width="400" height="200"></canvas>
        </div>
      </div>

      <!-- Revenue Chart Card -->
      <div class="bg-white shadow-md rounded-lg p-4 flex-1">
        <h2 class="text-xl font-bold mb-3">Revenue</h2>
        <canvas id="revenueChart" width="400" height="200"></canvas>
      </div>
    </div>



  </div>



  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize the Chart
      var ctx = document.getElementById('fleetStatusChart').getContext('2d');
      var fleetStatusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Available', 'On Rental', 'In Maintenance'],
          datasets: [{
            label: 'Fleet Status',
            data: [0, 0, 0], // Initial placeholder data
            backgroundColor: ['#3498db', '#e74c3c', '#f1c40f'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });

      // Function to Fetch and Update Data
      function fetchAndUpdateData() {
        fetch('get_vehicle_data.php')
          .then(response => response.json())
          .then(data => {
            // Update Chart
            fleetStatusChart.data.datasets[0].data = [
              data['Available'],
              data['On Rental'],
              data['In Maintenance']
            ];
            fleetStatusChart.update();

            // Update Status Counts
            document.querySelector('.available-count').textContent = data['Available'];
            document.querySelector('.on-rental-count').textContent = data['On Rental'];
            document.querySelector('.in-maintenance-count').textContent = data['In Maintenance'];
          })
          .catch(error => console.error('Error:', error));
      }

      // Fetch Data on Load and Periodically Update
      fetchAndUpdateData();
      setInterval(fetchAndUpdateData, 5000); // Refresh every 5 seconds
    });
    // Initial setup when the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
      var fleetTrigger = document.getElementById('fleet-management-trigger');
      var fleetMenu = document.getElementById('fleet-management-menu');
      fleetTrigger.addEventListener('click', function() {
        fleetMenu.classList.toggle('hidden');
      });

      document.getElementById('success-banner')?.addEventListener('click', function() {
        this.style.display = 'none';
      });
      document.getElementById('error-banner')?.addEventListener('click', function() {
        this.style.display = 'none';
      });
    });




    document.addEventListener('DOMContentLoaded', function() {
      function fetchUsersData() {
        fetch('getUsersData.php')
          .then(response => response.json())
          .then(data => {
            document.getElementById('total-users').textContent = data.totalUsers;
            document.getElementById('approved-bookings').textContent = data.approvedBookings;
          })
          .catch(error => {
            console.error('Error:', error);
            // Fallback text or action
            document.getElementById('total-users').textContent = 'Unavailable';
            document.getElementById('approved-bookings').textContent = 'Unavailable';
          });
      }

      // Call the function to fetch data
      fetchUsersData();

      // Optionally set an interval to refresh the data periodically
      // setInterval(fetchUsersData, 10000); // Refresh every 10 seconds
    });

    document.addEventListener('DOMContentLoaded', function() {
      function fetchBookingsData() {
        fetch('getBookingsData.php')
          .then(response => response.json())
          .then(data => {
            document.getElementById('active-bookings').textContent = data.activeBookings;
            document.getElementById('completed-bookings').textContent = data.completedBookings;
          })
          .catch(error => {
            console.error('Error:', error);
            document.getElementById('active-bookings').textContent = 'Unavailable';
            document.getElementById('completed-bookings').textContent = 'Unavailable';
          });
      }

      fetchBookingsData();
      // Optionally, set an interval to refresh the data periodically
      // setInterval(fetchBookingsData, 10000); // Refresh every 10 seconds
    });


    //monthly booking chart
    // Inside your 'DOMContentLoaded' event listener
    document.addEventListener('DOMContentLoaded', function() {
      fetch('getMonthlyBookings.php')
        .then(response => response.json())
        .then(data => {
          var ctx = document.getElementById('monthlyBookingsChart').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.months,
              datasets: [{
                label: 'Monthly Bookings',
                data: data.bookings,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        })
        .catch(error => console.error('Error:', error));
    });

    //  Monthly Revenue Chart
    document.addEventListener('DOMContentLoaded', function() {
      fetch('fetchRevenueData.php')
        .then(response => response.json())
        .then(data => {
          const dailyRevenueData = Object.entries(data.dailyRevenues).map(([date, total]) => ({
            x: date,
            y: total
          }));
          const monthlyRevenueData = Object.entries(data.monthlyRevenues).map(([date, total]) => ({
            x: date,
            y: total
          }));

          var ctx = document.getElementById('revenueChart').getContext('2d');
          var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
              datasets: [{
                  label: 'Daily Revenue',
                  data: dailyRevenueData,
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Monthly Revenue',
                  data: monthlyRevenueData,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              scales: {
                xAxes: [{
                  type: 'time',
                  time: {
                    unit: 'day'
                  },
                  distribution: 'linear'
                }],
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        })
        .catch(error => console.error('Error:', error));
    });
  </script>


</body>

</html>