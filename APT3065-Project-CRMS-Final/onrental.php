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

    <?php
    require_once('connection.php');
    // Select cars with the status 'On Rental'
    $query = "SELECT * FROM cars WHERE STATUS = 'On Rental'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Error in query execution: " . mysqli_error($con);
        exit;
    }
    ?>



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

    <!----------------------MAIN CONTENT ------------->
    <!--  Header -->
    <div class="pt-20 pl-72 pr-10 pb-4 overflow-auto">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Cars on Rental</h1>
        <div class="mt-5 bg-white shadow overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAR ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAR NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FUEL TYPE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAPACITY</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PRICE</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (mysqli_num_rows($result) > 0) : ?>
                        <?php while ($car = mysqli_fetch_array($result)) : ?>
                            <tr class='hover:bg-gray-100'>
                                <td class='px-6 py-4 whitespace-nowrap'><?= htmlspecialchars($car['CAR_ID']) ?></td>
                                <td class='px-6 py-4 whitespace-nowrap'><?= htmlspecialchars($car['CAR_NAME']) ?></td>
                                <td class='px-6 py-4 whitespace-nowrap'><?= htmlspecialchars($car['FUEL_TYPE']) ?></td>
                                <td class='px-6 py-4 whitespace-nowrap'><?= htmlspecialchars($car['CAPACITY']) ?></td>
                                <td class='px-6 py-4 whitespace-nowrap'><?= htmlspecialchars($car['PRICE']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                </tbody>
            </table>
            <div class="text-center py-8">
                <div class="text-gray-500">No cars on rental</div>
            </div>
        <?php endif; ?>
        </div>
    </div>




    <script>
        // <!-- Optional JavaScript for handling dropdown toggle more interactively -->
        document.addEventListener("DOMContentLoaded", function() {
            var fleetTrigger = document.getElementById('fleet-management-trigger');
            var fleetMenu = document.getElementById('fleet-management-menu');

            fleetTrigger.addEventListener('click', function() {
                fleetMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>