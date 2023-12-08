<?php
session_start();
require_once('connection.php');

$query = "SELECT * FROM cars WHERE STATUS = 'Available'";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error in query execution: " . mysqli_error($con);
    exit;
}
?>

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-200 font-sans">







    <!-- Top Navigation Bar -->
    <div class="fixed top-0 right-0 left-64 h-16 bg-white shadow flex items-center justify-end px-6 z-10">
        <!-- Admin Profile Section -->
        <div class="flex items-center">
            <span class="text-gray-800 text-sm mr-4">Welcome, Admin!</span>
            <img src="images/profile.png" alt="Admin Profile" class="h-10 w-10 rounded-full border-2 border-gray-300">
        </div>
    </div>




    <div class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white p-5">
        <!-- Logo Placeholder -->
        <div class="flex justify-center mb-6">
            <img src="images/IMG-656266d6e523d0.97591890.jpg" alt="Logo" class="h-12">
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



    <!-- Maintenance Records Section -->
    <div class="pt-20 pl-72 pr-10 pb-4 overflow-auto">

        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Services</h1>
        <div class="mt-5 bg-white shadow overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if (isset($_SESSION['maintenance_records']) && count($_SESSION['maintenance_records']) > 0) {
                        foreach ($_SESSION['maintenance_records'] as $record) {
                            echo "<tr>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($record['car_id']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($record['CarName']) . "</td>"; // Display the car name
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($record['ServiceName']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($record['description']) . "</td>";
                            // Updated design with green text and green circle with tick
                            echo "<td class='px-6 py-4 whitespace-nowrap'>";
                            echo "<button onclick='closeService(" . $record['car_id'] . ")' class='text-green-500 hover:text-green-700 font-bold flex items-center'>";
                            echo "<svg class='mr-2' width='16' height='16' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                            echo "<circle cx='10' cy='10' r='10' fill='green'/>";
                            echo "<path d='M5 10L8 13L15 6' stroke='white' stroke-width='2'/>";
                            echo "</svg>";
                            echo "Close Service";
                            echo "</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If there are no records, close the table and show the "No services" message
                        echo '</tbody></table>'; // Close the table tags
                        echo '<div class="flex flex-col items-center justify-center h-64">';
                        echo '<svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">';
                        echo '<path d="M9.172 16.828a4 4 0 005.656 0M21 12H3"></path>';
                        echo '<path d="M17.657 16.657A8 8 0 116.343 5.343a8 8 0 0111.314 11.314z"></path>';
                        echo '</svg>';
                        echo '<span class="text-lg font-medium text-gray-400">No services</span>';
                        echo '<p class="text-sm text-gray-400">There are no due services in your fleet.</p>';
                        echo '</div>';
                    }
                    ?>




                </tbody>
            </table>
        </div>

        <!-- Close Service Confirmation Modal -->
        <div id="closeServiceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Close Service Confirmation</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500" id="closeServiceMessage">Are you sure you want to close the service for this car?</p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="closeServiceCancel" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2">Cancel</button>
                        <button id="closeServiceConfirm" class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-24">Close Service</button>
                    </div>
                </div>
            </div>
        </div>




        <script>
            // Document ready function
            document.addEventListener("DOMContentLoaded", function() {
                // Handle fleet management dropdown toggle
                var fleetTrigger = document.getElementById('fleet-management-trigger');
                var fleetMenu = document.getElementById('fleet-management-menu');

                fleetTrigger.addEventListener('click', function() {
                    fleetMenu.classList.toggle('hidden');
                });

                // Close service function
                function closeService(carId) {
                    // Show the close service modal
                    document.getElementById('closeServiceModal').classList.remove('hidden');

                    // Confirm button action
                    var confirmBtn = document.getElementById('closeServiceConfirm');
                    confirmBtn.onclick = function() {
                        sendCloseServiceRequest(carId);
                    };

                    // Cancel button action
                    var cancelBtn = document.getElementById('closeServiceCancel');
                    cancelBtn.onclick = function() {
                        document.getElementById('closeServiceModal').classList.add('hidden');
                    };
                }

                // Function to send AJAX request to close service
                function sendCloseServiceRequest(carId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "closeServiceHandler.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                            location.reload(); // Reload the page to reflect changes
                        }
                    }
                    xhr.send("car_id=" + carId);
                    document.getElementById('closeServiceModal').classList.add('hidden');
                }

                // Make the closeService function available globally
                window.closeService = closeService;
            });
        </script>

</body>

</html>