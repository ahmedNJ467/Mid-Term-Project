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

    <!-- Redesigned Sidebar -->
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
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Users</h1>
        <!-- Users Table -->
        <div class="mt-5 bg-white shadow overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">National ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver's License</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    require_once('connection.php');
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($con, $query);
                    while ($user = mysqli_fetch_array($result)) {
                        echo "<tr class='hover:bg-gray-100 cursor-pointer' onclick='toggleUserOptionsPanel(this)'>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($user['FNAME']) . " " . htmlspecialchars($user['LNAME']) . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($user['EMAIL']) . "</td>";
                        echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($user['PHONE_NUMBER']) . "</td>";

                        // For National ID
                        if (!empty($user['NATIONALID_FILENAME'])) {
                            echo "<td class='px-6 py-4 whitespace-nowrap'><a href='download.php?type=nationalid&file=" . urlencode($user['NATIONALID_FILENAME']) . "'>Download National ID</a></td>";
                        } else {
                            echo "<td class='px-6 py-4 whitespace-nowrap'>Not available</td>";
                        }

                        // For Driver's License
                        if (!empty($user['DRIVERSLICENSE_FILENAME'])) {
                            echo "<td class='px-6 py-4 whitespace-nowrap'><a href='download.php?type=driverslicense&file=" . urlencode($user['DRIVERSLICENSE_FILENAME']) . "'>Download Driver's License</a></td>";
                        } else {
                            echo "<td class='px-6 py-4 whitespace-nowrap'>Not available</td>";
                        }

                        echo "</tr>";

                        // Hidden options panel row
                        echo "<tr class='user-options-panel hidden bg-gray-200 text-center'>";
                        echo "<td colspan='5' class='px-6 py-4'>";
                        echo "<button onclick='event.stopPropagation(); openEditUserModal(" . json_encode($user) . ")' class='text-indigo-500 hover:text-indigo-700 mr-4'>Edit</button>";
                        echo "<button onclick='event.stopPropagation(); openDeleteUserConfirmationModal(\"" . htmlspecialchars($user['EMAIL']) . "\")' class='text-red-500 hover:text-red-700'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-8 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit User</h3>
                <form action="edituser.php" method="POST" enctype="multipart/form-data">
                    <!-- Hidden Field for Email (Identifier) -->
                    <input type="hidden" id="editUserId" name="email">

                    <!-- First Name -->
                    <div class="mb-4">
                        <label for="editUserFirstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="editUserFirstName" name="fname" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label for="editUserLastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="editUserLastName" name="lname" required class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>



                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="editUserPhone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" id="editUserPhone" name="phone_number" class="px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- National ID Image and Upload Field -->
                    <div class="mb-4">
                        <label for="editUserNationalIdUpload" class="block text-sm font-medium text-gray-700 mb-2">National ID</label>
                        <img id="editUserNationalIdImage" src="#" alt="National ID" class="mb-2 h-20 w-auto" style="display: none;">
                        <input type="file" id="editUserNationalIdUpload" name="national_id_upload" class="px-4 py-2 block w-full text-sm text-gray-700 border-2 border-gray-300 rounded-md">
                    </div>

                    <!-- Driver's License Image and Upload Field -->
                    <div class="mb-4">
                        <label for="editUserDriversLicenseUpload" class="block text-sm font-medium text-gray-700 mb-2">Driver's License</label>
                        <img id="editUserDriversLicenseImage" src="#" alt="Driver's License" class="mb-2 h-20 w-auto" style="display: none;">
                        <input type="file" id="editUserDriversLicenseUpload" name="drivers_license_upload" class="px-4 py-2 block w-full text-sm text-gray-700 border-2 border-gray-300 rounded-md">
                    </div>


                    <!-- Submit and Cancel Buttons -->
                    <div class="flex justify-center mt-6 gap-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Save Changes
                        </button>
                        <button type="button" onclick="closeModal('editUserModal')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Delete User Confirmation Modal -->
    <div id="deleteUserConfirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Confirmation</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Are you sure you want to delete this user? This action cannot be undone.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="deleteCancel" onclick="closeModal('deleteUserConfirmationModal')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2">Cancel</button>
                    <button id="deleteConfirm" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        function toggleUserOptionsPanel(row) {
            // Prevents the row from toggling when a button inside it is clicked
            if (event.target.tagName === 'BUTTON') {
                return;
            }

            let optionsPanel = row.nextElementSibling;
            while (optionsPanel && !optionsPanel.classList.contains('user-options-panel')) {
                optionsPanel = optionsPanel.nextElementSibling;
            }
            if (optionsPanel) {
                optionsPanel.classList.toggle('hidden');
            }
        }

        function openEditUserModal(userData) {
            // Assuming userData contains the details of the user to be edited
            if (typeof userData === 'string') {
                userData = JSON.parse(userData);
            }

            // Set the values in the edit user form fields
            document.getElementById('editUserId').value = userData.EMAIL;
            document.getElementById('editUserFirstName').value = userData.FNAME;
            document.getElementById('editUserLastName').value = userData.LNAME;
            document.getElementById('editUserPhone').value = userData.PHONE_NUMBER;

            // Set the National ID and Driver's License images if available
            if (userData.NATIONAL_ID_FILENAME) {
                document.getElementById('editUserNationalIdImage').src = 'userupload/national_id/' + userData.NATIONAL_ID_FILENAME;
                document.getElementById('editUserNationalIdImage').style.display = 'block';
            }
            if (userData.DRIVERS_LICENSE_FILENAME) {
                document.getElementById('editUserDriversLicenseImage').src = 'userupload/drivers_license/' + userData.DRIVERS_LICENSE_FILENAME;
                document.getElementById('editUserDriversLicenseImage').style.display = 'block';
            }

            // Open the edit user modal
            document.getElementById('editUserModal').classList.remove('hidden');
        }


        function openDeleteUserConfirmationModal(userId) {
            // Set the action on the delete confirmation button
            document.getElementById('deleteConfirm').setAttribute('onclick', `confirmDelete('${userId}')`);
            // Show the delete confirmation modal
            document.getElementById('deleteUserConfirmationModal').classList.remove('hidden');
        }

        function confirmDelete(userId) {
            // Redirect to a PHP script to handle deletion, passing the userId
            window.location.href = `deleteuser.php?id=${userId}`;
        }

        // Functions to close modals
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        // Close the success and error banners
        document.getElementById('success-banner')?.addEventListener('click', function() {
            this.style.display = 'none';
        });

        document.getElementById('error-banner')?.addEventListener('click', function() {
            this.style.display = 'none';
        });
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