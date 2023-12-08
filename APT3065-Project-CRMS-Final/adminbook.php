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


<body class="bg-gray-200 font-sans">


    <!-- PHP script to handle the session alerts -->
    <?php
    session_start();
    if (isset($_SESSION['success'])) {
        $success_message = $_SESSION['success'];
        unset($_SESSION['success']); // Clear the message after displaying
    }
    if (isset($_SESSION['error'])) {
        $error_message = $_SESSION['error'];
        unset($_SESSION['error']); // Clear the message after displaying
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
    <!-- Main Content -->
    <div class="pt-20 pl-72 pr-10 pb-4 overflow-auto">
        <!-- Alert banners -->
        <?php if (isset($success_message)) : ?>
            <div id="success-banner" class="flex items-center bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <svg class="fill-current text-green-500 w-6 h-6 mr-2" viewBox="0 0 20 20">
                    <path d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586 4.707 9.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414z" />
                </svg>
                <p class="font-bold"><?php echo $success_message; ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)) : ?>
            <div id="error-banner" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Error</p>
                <p><?php echo $error_message; ?></p>
            </div>

        <?php endif; ?>
        <h1 class="text-3xl font-bold text-gray-800 mb-5">Bookings</h1>

        <!-- Scrollable Bookings Table -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Place</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    require_once('connection.php');
                    $query = "SELECT * FROM booking ORDER BY BOOK_ID DESC";
                    $queryy = mysqli_query($con, $query);

                    while ($res = mysqli_fetch_array($queryy)) {
                        $bookingId = $res['BOOK_ID'];
                        $carId = $res['CAR_ID'];

                        echo "<tr class='bg-white'>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['CAR_ID'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['EMAIL'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['BOOK_PLACE'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['BOOK_DATE'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['DURATION'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['PHONE_NUMBER'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['DESTINATION'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['RETURN_DATE'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>" . $res['BOOK_STATUS'] . "</td>
        <td class='px-6 py-4 whitespace-nowrap'>
            <div class='relative'>
                <select class='block w-30 md:w-26 lg:w-30 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 text-sm p-2.5' onchange='handleAction(this, \"$bookingId\", \"$carId\")'>
                    <option value=''>Select Action</option>
                    <option value='approve'>Approve</option>
                    <option value='returned'>Returned</option>
                </select>
            </div>
        </td>
    </tr>";
                    }
                    ?>
                    <script>
                        // Function to handle the action change
                        function handleAction(selectElement, bookingId, carId) {
                            var action = selectElement.value;
                            if (action === 'approve') {
                                window.location.href = 'approve.php?id=' + bookingId;
                            } else if (action === 'returned') {
                                window.location.href = 'adminreturn.php?id=' + carId + '&bookid=' + bookingId;
                            }
                        }

                        // Event listener for DOM content loaded
                        document.addEventListener("DOMContentLoaded", function() {
                            // Toggle fleet management menu
                            var fleetTrigger = document.getElementById('fleet-management-trigger');
                            var fleetMenu = document.getElementById('fleet-management-menu');
                            fleetTrigger.addEventListener('click', function() {
                                fleetMenu.classList.toggle('hidden');
                            });

                            // Close banners on click
                            document.getElementById('success-banner')?.addEventListener('click', function() {
                                this.style.display = 'none';
                            });
                            document.getElementById('error-banner')?.addEventListener('click', function() {
                                this.style.display = 'none';
                            });
                        });
                    </script>


                </tbody>
            </table>
        </div>
    </div>

</body>

</html>