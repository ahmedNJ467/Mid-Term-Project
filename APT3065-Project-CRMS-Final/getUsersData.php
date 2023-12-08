<?php
require_once('connection.php');

// Query to get the total number of users
$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$totalUsersResult = mysqli_query($con, $totalUsersQuery);
$totalUsersRow = mysqli_fetch_assoc($totalUsersResult);
$totalUsers = $totalUsersRow['total'];

// Query to get the number of users with approved bookings
$approvedBookingsQuery = "SELECT COUNT(DISTINCT EMAIL) as approved FROM booking WHERE BOOK_STATUS = 'APPROVED'";
$approvedBookingsResult = mysqli_query($con, $approvedBookingsQuery);
$approvedBookingsRow = mysqli_fetch_assoc($approvedBookingsResult);
$approvedBookings = $approvedBookingsRow['approved'];

header('Content-Type: application/json');
echo json_encode([
    'totalUsers' => $totalUsers,
    'approvedBookings' => $approvedBookings
]);
