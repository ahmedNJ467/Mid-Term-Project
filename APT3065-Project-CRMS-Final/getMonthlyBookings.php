<?php
require_once('connection.php');

// Initialize an array with all months and default count to 0
$monthlyBookings = array_fill(1, 12, 0);

// SQL query
$sql = "SELECT MONTH(book_date) AS month, COUNT(*) AS booking_count FROM booking GROUP BY MONTH(book_date)";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Update booking count for each month
    while ($row = $result->fetch_assoc()) {
        $monthlyBookings[$row["month"]] = $row["booking_count"];
    }
}

$con->close();

// Prepare data for chart
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$bookings = array_values($monthlyBookings);

// Convert data to JSON format
header('Content-Type: application/json');
echo json_encode(['months' => $months, 'bookings' => $bookings]);
