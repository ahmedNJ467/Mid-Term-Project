<?php
require_once('connection.php');
session_start();

$carid = $_GET['id'];
$book_id = $_GET['bookid'];

// Check if the car is currently on rental
$sql = "SELECT * FROM cars WHERE CAR_ID = $carid AND STATUS = 'On Rental'";
$result = mysqli_query($con, $sql);
$carExists = mysqli_num_rows($result) > 0;

if ($carExists) {
    // Update the car status to 'Available'
    $sqlUpdateCar = "UPDATE cars SET STATUS = 'Available' WHERE CAR_ID = $carid";
    mysqli_query($con, $sqlUpdateCar);

    // Update the booking status to 'Returned'
    $sqlUpdateBooking = "UPDATE booking SET BOOK_STATUS = 'Returned' WHERE BOOK_ID = $book_id";
    mysqli_query($con, $sqlUpdateBooking);

    $_SESSION['success'] = "Car returned successfully";
} else {
    $_SESSION['error'] = "The car is not currently on rental";
}

header("Location: adminbook.php");
exit();
