<?php
require_once('connection.php');

$perPage = 8; // Number of cars per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startAt = ($page - 1) * $perPage;

$fuelType = $_GET['fuel_type'] ?? '';
$sortPrice = $_GET['sort_price'] ?? '';
$make = $_GET['make'] ?? ''; // Retrieve the 'make' parameter
$model = $_GET['model'] ?? ''; // Retrieve the 'model' parameter

// Update the query to check for 'Available' status
$query = "SELECT * FROM cars WHERE STATUS='Available'";

// Apply filters
if (!empty($fuelType)) {
    $query .= " AND FUEL_TYPE = '" . mysqli_real_escape_string($con, $fuelType) . "'";
}
if (!empty($make)) {
    $query .= " AND Make = '" . mysqli_real_escape_string($con, $make) . "'";
}
if (!empty($model)) {
    $query .= " AND Model = '" . mysqli_real_escape_string($con, $model) . "'";
}

// Apply sorting
if ($sortPrice == 'asc') {
    $query .= " ORDER BY PRICE ASC";
} elseif ($sortPrice == 'desc') {
    $query .= " ORDER BY PRICE DESC";
} else {
    // Default sorting
    $query .= " ORDER BY CAR_NAME";
}

// Count total cars and total pages
$totalQuery = "SELECT COUNT(*) as total FROM (" . $query . ") as totalQuery";
$totalResult = mysqli_query($con, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalCars = $totalRow['total'];
$totalPages = ceil($totalCars / $perPage);

// Fetch cars for the current page
$query .= " LIMIT $startAt, $perPage";
$result = mysqli_query($con, $query);

// Generate HTML content for cars
$htmlContent = '';
while ($row = mysqli_fetch_assoc($result)) {
    $htmlContent .= "
    <div class='max-w-sm w-full md:w-1/3 lg:w-1/4 p-4'>
        <div class='bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg'>
            <div class='overflow-hidden'>
                <img class='w-full h-48 object-cover transform transition duration-300 ease-in-out hover:scale-110' src='images/{$row['CAR_IMG']}' alt='{$row['CAR_NAME']} Image'>
            </div>
            <div class='p-4'>
                <h5 class='font-bold text-xl mb-2'>{$row['CAR_NAME']}</h5>
                <p class='text-gray-700 text-base mb-4'>
                    Fuel Type: {$row['FUEL_TYPE']}<br>
                    Capacity: {$row['CAPACITY']}<br>
                    Rent Per Day: KSH {$row['PRICE']}
                </p>
                <a href='booking.php?id={$row['CAR_ID']}' class='inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline'>Book Now</a>
            </div>
        </div>
    </div>
    ";
}

// Return HTML and total pages as JSON
echo json_encode(['html' => $htmlContent, 'totalPages' => $totalPages]);
