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
    <script>
        function scheduleMaintenance(carId) {
            // Implement AJAX call or redirect to handle maintenance scheduling
            // Example: window.location.href = `scheduleMaintenance.php?car_id=${carId}`;
        }
    </script>

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


    <!------------------------------ SIDEBAR ------------- -->

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

        <!--  Header -->
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">All cars</h1>
        <!-- Modern Add Car Button -->
        <button onclick="openModal()" class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
            <i class="fas fa-plus mr-2"></i>New Car
        </button>


        <!-- Car Table -->
        <div class="mt-5 bg-white shadow overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAR ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAR NAME</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FUEL TYPE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CAPACITY</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PRICE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    require_once('connection.php');
                    $query = "SELECT * FROM cars";
                    $queryy = mysqli_query($con, $query);

                    while ($res = mysqli_fetch_array($queryy)) {
                        $carId = $res['CAR_ID'];
                        $carName = htmlspecialchars($res['CAR_NAME'], ENT_QUOTES);
                        $carStatus = $res['STATUS']; // Get the status of the car

                        echo "<tr class='hover:bg-gray-100 cursor-pointer'";
                        // Check if car status is not 'In Maintenance' or 'On Rental' before adding onclick event
                        if ($carStatus !== 'In Maintenance' && $carStatus !== 'On Rental') {
                            echo " onclick='toggleOptionsPanel(this)'";
                        }
                        echo ">";

                        // Car data rows
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $res['CAR_ID'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $carName . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $res['FUEL_TYPE'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $res['CAPACITY'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $res['PRICE'] . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . $res['STATUS'] . "</td>";
                        echo "</tr>";

                        // Hidden options panel row with deep shadow effect
                        echo "<tr class='options-panel hidden bg-gray-200 text-center shadow-2xl'>";
                        echo "<td colspan='6' class='px-6 py-4'>";
                        if ($carStatus !== 'In Maintenance' and $carStatus !== 'On Rental') {
                            echo "<button onclick='event.stopPropagation(); openEditModal(" . json_encode($res) . ", event)' class='text-indigo-500 hover:text-indigo-700 mr-4'>Edit</button>";
                            echo "<button onclick='openMaintenanceModal(\"$carId\", \"$carName\", event)' class='text-blue-500 hover:text-blue-700 mr-4'>Schedule Maintenance</button>";
                            echo "<button onclick='openDeleteModal(" . $carId . ")' class='text-red-500 hover:text-red-700'>Delete</button>";
                        } else {
                            echo "<span class='text-gray-500'>Options unavailable</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>


                </tbody>
            </table>

        </div>


        <!-- Delete Confirmation Modal using Tailwind CSS -->
        <div id="deleteConfirmationModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Confirmation
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this car? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="confirmDelete()">
                            Delete
                        </button>


                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeDeleteModal()">Cancel</button>


                    </div>
                </div>
            </div>
        </div>

        <script>
            var carIdToDelete = null;

            function openDeleteModal(carId) {
                carIdToDelete = carId;
                document.getElementById('deleteConfirmationModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('deleteConfirmationModal').classList.add('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteConfirmationModal').classList.add('hidden');
            }



            function confirmDelete() {
                if (carIdToDelete !== null) {
                    window.location.href = `deletecar.php?id=${carIdToDelete}`;
                }
            }
        </script>


        <!-- Add Car Modal -->
        <div id="addCarModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-8 border w-96 shadow-lg rounded-md bg-white">
                <div class="text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Car</h3>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <!-- Car Name -->
                        <div class="mb-4">
                            <label for="carname" class="block text-sm font-medium text-gray-700 mb-2">Car Name</label>
                            <input type="text" id="carname" name="carname" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>
                        <!-- Make -->
                        <div class="mb-4">
                            <label for="make" class="block text-sm font-medium text-gray-700 mb-2">Make</label>
                            <input type="text" id="make" name="make" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>

                        <!-- Model -->
                        <div class="mb-4">
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                            <input type="text" id="model" name="model" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>
                        <!-- Fuel Type -->
                        <div class="mb-4">
                            <label for="ftype" class="block text-sm font-medium text-gray-700 mb-2">Fuel Type</label>
                            <input type="text" id="ftype" name="ftype" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>

                        <!-- Capacity -->
                        <div class="mb-4">
                            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                            <input type="number" id="capacity" name="capacity" min="1" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                            <input type="number" id="price" name="price" min="1" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>

                        <!-- Car Image -->
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Car Image</label>
                            <input type="file" id="image" name="image" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-center mt-6 gap-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                                Add Car
                            </button>
                            <button type="button" onclick="closeModal()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Car Modal -->
    <div id="editCarModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-8 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Car</h3>
                <form action="editcar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editCarId" name="car_id">

                    <!-- Car Name -->
                    <div class="mb-4">
                        <label for="editCarName" class="block text-sm font-medium text-gray-700 mb-2">Car Name</label>
                        <input type="text" id="editCarName" name="car_name" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Fuel Type -->
                    <div class="mb-4">
                        <label for="editFuelType" class="block text-sm font-medium text-gray-700 mb-2">Fuel Type</label>
                        <input type="text" id="editFuelType" name="ftype" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Capacity -->
                    <div class="mb-4">
                        <label for="editCapacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                        <input type="number" id="editCapacity" name="capacity" min="1" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="editPrice" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                        <input type="number" id="editPrice" name="price" min="1" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Current Car Image Preview -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Car Image</label>
                        <img id="editImagePreview" src="" alt="Car Image" class="max-w-xs max-h-40" />
                    </div>

                    <!-- Car Image Upload -->
                    <div class="mb-4">
                        <label for="editImage" class="block text-sm font-medium text-gray-700 mb-2">Change Car Image</label>
                        <input type="file" id="editImage" name="image" class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="flex justify-center mt-6 gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Save Changes
                        </button>
                        <button type="button" onclick="closeModal()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Schedule Maintenance Modal -->
    <div id="scheduleMaintenanceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-8 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Schedule Service for <span id="maintenanceCarName"></span></h3>
                <form id="maintenanceForm" action="maintenanceHandler.php" method="POST">
                    <!-- Hidden Car ID -->
                    <input type="hidden" id="maintenanceCarId" name="car_id">
                    <!-- Hidden Car Name -->
                    <input type="hidden" id="hiddenCarName" name="CarName">
                    <!-- Service Name -->
                    <div class="mb-4">
                        <label for="ServiceName" class="block text-sm font-medium text-gray-700 mb-2">Service Name</label>
                        <input type="text" id="maintenanceName" name="ServiceName" required class="px-4 py-2 border border-gray-300 rounded-md w-full">
                    </div>
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="maintenanceDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="maintenanceDescription" name="description" required class="px-4 py-2 border border-gray-300 rounded-md w-full"></textarea>
                    </div>
                    <!-- Buttons -->
                    <div class="flex justify-center mt-6 gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Schedule
                        </button>
                        <button type="button" onclick="closeMaintenanceModal()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Cancel
                        </button>
                </form>
            </div>
        </div>
    </div>






    <script>
        // Global variable for deletion
        var currentDeletingCarId = null;

        function openModal() {
            closeModal(); // Close any open modals first
            document.getElementById('addCarModal').classList.remove('hidden');
        }

        // Close All Modals
        function closeModal() {
            document.getElementById('addCarModal').classList.add('hidden');
            document.getElementById('editCarModal').classList.add('hidden');
            document.getElementById('scheduleMaintenanceModal').classList.add('hidden');
        }

        // Toggle Options Panel
        function toggleOptionsPanel(row) {
            let optionsPanel = row.nextElementSibling;
            optionsPanel.classList.toggle('hidden');
        }

        function deleteCar(carId) {
            if (confirm("Are you sure you want to delete this car?")) {
                window.location.href = `deletecar.php?id=${carId}`;
            }
        }

        // Toggle Options Panel
        function toggleOptionsPanel(row) {
            let optionsPanel = row.nextElementSibling;
            optionsPanel.classList.toggle('hidden');
        }

        function openEditModal(carData, event) {
            event.stopPropagation();
            closeModal(); // Close other modals
            if (typeof carData === 'string') {
                carData = JSON.parse(carData);
            }
            document.getElementById('editCarId').value = carData.CAR_ID;
            document.getElementById('editCarName').value = carData.CAR_NAME;
            document.getElementById('editFuelType').value = carData.FUEL_TYPE;
            document.getElementById('editCapacity').value = carData.CAPACITY;
            document.getElementById('editPrice').value = carData.PRICE;
            var imagePreview = document.getElementById('editImagePreview');
            imagePreview.src = carData.CAR_IMG ? 'images/' + carData.CAR_IMG : '';
            imagePreview.style.display = carData.CAR_IMG ? 'block' : 'none';
            document.getElementById('editCarModal').classList.remove('hidden');
        }

        // Open Maintenance Modal
        function openMaintenanceModal(carId, carName, event) {
            event.stopPropagation();
            closeModal(); // Close other modals
            document.getElementById('maintenanceCarId').value = carId;
            document.getElementById('hiddenCarName').value = carName;
            document.getElementById('maintenanceCarName').textContent = carName;
            document.getElementById('scheduleMaintenanceModal').classList.remove('hidden');
        }

        // Schedule Maintenance (Placeholder for future implementation)
        function scheduleMaintenance(carId) {
            openMaintenanceModal(carId);
        }

        // Close Maintenance Modal
        function closeMaintenanceModal() {
            document.getElementById('scheduleMaintenanceModal').classList.add('hidden');
        }

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
    </script>



</body>

</html>