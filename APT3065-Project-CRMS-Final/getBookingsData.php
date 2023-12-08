<?php
require_once('connection.php');

// Query to get the number of active bookings
$activeBookingsQuery = "SELECT COUNT(*) as active FROM booking WHERE BOOK_STATUS = 'APPROVED'";
$activeBookingsResult = mysqli_query($con, $activeBookingsQuery);
$activeBookingsRow = mysqli_fetch_assoc($activeBookingsResult);
$activeBookings = $activeBookingsRow['active'];

// Query to get the number of completed bookings
$completedBookingsQuery = "SELECT COUNT(*) as completed FROM booking WHERE BOOK_STATUS = 'RETURNED'";
$completedBookingsResult = mysqli_query($con, $completedBookingsQuery);
$completedBookingsRow = mysqli_fetch_assoc($completedBookingsResult);
$completedBookings = $completedBookingsRow['completed'];

header('Content-Type: application/json');
echo json_encode([
    'activeBookings' => $activeBookings,
    'completedBookings' => $completedBookings
]);
