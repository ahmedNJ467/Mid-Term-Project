<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body class="bg-gray-400">
    <?php
    session_start();
    require_once('connection.php');
    $email = $_SESSION['email'];

    $userQuery = "SELECT FNAME, LNAME FROM users WHERE EMAIL = '$email'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $userName = $userData['FNAME'] . " " . $userData['LNAME'];

    // Check if the feedback_success message is set
    if (isset($_SESSION['feedback_success'])) {
        echo '<script>alert("' . $_SESSION['feedback_success'] . '")</script>';
        unset($_SESSION['feedback_success']); // Clear the message after displaying
    }
    ?>

    <!-- Navigation Bar -->
    <nav class="bg-gray-900 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="#">CRMS</a>
            <div class="flex items-center space-x-4">
                <a class="hover:text-gray-300" href="cardetails.php">Home</a>
                <a class="hover:text-gray-300" href="bookinstatus.php">Booking Status</a>
                <a class="hover:text-gray-300" href="feedback/Feedbacks.php">Feedback</a>
                <a class="hover:text-gray-300" href="index.php">Logout</a>
            </div>
            <div class="flex items-center ml-6">
                <img src="images/profile.png" class="h-8 w-8 rounded-full mr-2" alt="Profile">
                Hello, <?php echo $userName; ?>!
            </div>
        </div>
    </nav>
    <!-- Car Catalogue Heading -->
    <div class="container mx-auto px-4 py-4 text-center">
        <h2 class="text-3xl font-semibold mb-6">Find Your Perfect Car</h2>
    </div>

    <!-- Filter & Sort Form -->
    <div class="container mx-auto px-4 pb-4">
        <div class="flex justify-center gap-4 flex-wrap">
            <!-- Make Filter -->
            <div class="flex-grow max-w-sm">
                <select id="makeFilter" class="block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm p-2.5">
                    <option value="">Select Make</option>
                    <!-- Dynamically populate make options here -->
                </select>
            </div>

            <!-- Model Filter -->
            <div class="flex-grow max-w-sm">
                <select id="modelFilter" class="block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm p-2.5">
                    <option value="">Select Model</option>
                    <!-- Dynamically populate model options here -->
                </select>
            </div>

            <!-- Fuel Type Filter -->
            <div class="flex-grow max-w-sm">
                <select id="fuelType" class="block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm p-2.5">
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>

            <!-- Sort Price -->
            <div class="flex-grow max-w-sm">
                <select id="sortPrice" class="block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm p-2.5">
                    <option value="">Sort by Price</option>
                    <option value="asc">Low to High</option>
                    <option value="desc">High to Low</option>
                </select>
            </div>

            <!-- Apply Button -->
            <button id="applyFilters" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm text-sm font-medium py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Apply Filters
            </button>
        </div>
    </div>


    <!-- Car Slider Wrapper -->
    <div id="carSliderWrapper" class="container mx-auto px-4 py-4 overflow-hidden">
        <div id="carSlider" class="flex flex-wrap">
            <!-- Car items will be dynamically inserted here -->
        </div>
    </div>

    <!-- Slider Controls -->
    <nav aria-label="Page navigation example">
        <ul id="pagination" class="list-style-none flex justify-center mt-4">
            <!-- Pagination and navigation buttons will be dynamically inserted here -->
        </ul>
    </nav>




    <script>
        $(document).ready(function() {
            var currentPage = 1;
            var totalPages = 0;

            function fetchCars(page = 1) {
                var fuelType = $('#fuelType').val();
                var sortPrice = $('#sortPrice').val();
                var make = $('#makeFilter').val();
                var model = $('#modelFilter').val();

                $.ajax({
                    url: 'fetch_cars.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        fuel_type: fuelType,
                        sort_price: sortPrice,
                        make: make,
                        model: model,
                        page: page
                    },
                    success: function(response) {
                        $('#carSlider').html(response.html);
                        totalPages = response.totalPages;
                        currentPage = page;
                        updatePagination();
                    }
                });
            }

            function updatePagination() {
                var paginationHtml = '';

                // Previous Button
                paginationHtml += `<li><a class="${currentPage === 1 ? 'pointer-events-none text-neutral-500' : 'text-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-700 dark:hover:text-white'} relative block rounded-full bg-transparent px-3 py-1.5 text-sm transition-all duration-300" href="#!" onclick="fetchCars(${currentPage - 1})">Previous</a></li>`;

                // Page Numbers
                for (var i = 1; i <= totalPages; i++) {
                    var activeClass = i === currentPage ? 'bg-blue-200 rounded-full' : 'text-neutral-600 hover:bg-neutral-100 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white';
                    paginationHtml += `<li><a class="relative block rounded-full px-3 py-1.5 text-sm ${activeClass} transition-all duration-300" href="#!" onclick="fetchCars(${i})">${i}</a></li>`;
                }

                // Next Button
                paginationHtml += `<li><a class="${currentPage === totalPages ? 'pointer-events-none text-neutral-500' : 'text-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-700 dark:hover:text-white'} relative block rounded-full bg-transparent px-3 py-1.5 text-sm transition-all duration-300" href="#!" onclick="fetchCars(${currentPage + 1})">Next</a></li>`;

                $('#pagination').html(paginationHtml);
            }

            // Handle changes in the make filter
            $('#makeFilter').change(function() {
                var selectedMake = $(this).val();
                fetchModelsForMake(selectedMake);
            });

            // Fetch and update model options based on selected make
            function fetchModelsForMake(make) {
                $.ajax({
                    url: 'fetch_models_for_make.php',
                    type: 'GET',
                    data: {
                        make: make
                    },
                    dataType: 'json',
                    success: function(response) {
                        var modelFilter = $('#modelFilter');
                        modelFilter.empty(); // Clear existing options
                        modelFilter.append(new Option('Select Model', '')); // Add default option

                        // Populate models
                        $.each(response.models, function(index, model) {
                            modelFilter.append(new Option(model, model));
                        });
                    }
                });
            }

            // Existing applyFilters click event
            $('#applyFilters').click(function(e) {
                e.preventDefault();
                fetchCars();
            });

            // Initial fetch for cars
            fetchCars();

        });
        // AJAX call to populate makes
        $.ajax({
            url: 'fetch_makes_models.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var makeFilter = $('#makeFilter');
                $.each(response.makes, function(index, make) {
                    makeFilter.append(new Option(make, make));
                });
            }
        });
    </script>








</body>

</html>