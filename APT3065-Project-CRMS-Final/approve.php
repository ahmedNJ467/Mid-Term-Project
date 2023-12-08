<?php
require_once('connection.php');
session_start(); // Start the session to use session variables

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookid = $_GET['id'];

    // Begin transaction to ensure data integrity
    mysqli_begin_transaction($con);

    try {
        // Prepared statement to prevent SQL Injection
        $stmt = mysqli_prepare($con, "SELECT * FROM booking WHERE BOOK_ID = ?");
        mysqli_stmt_bind_param($stmt, 'i', $bookid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $res = mysqli_fetch_assoc($result);

        if (!$res) {
            // No booking found
            $_SESSION['error'] = "Invalid booking ID.";
            throw new Exception("Invalid booking ID.");
        }

        $car_id = $res['CAR_ID'];

        // Check the car's status
        $stmt2 = mysqli_prepare($con, "SELECT * FROM cars WHERE CAR_ID = ?");
        mysqli_stmt_bind_param($stmt2, 'i', $car_id);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $carresult = mysqli_fetch_assoc($result2);

        if (!$carresult) {
            // Car not found
            $_SESSION['error'] = "Car not found.";
            throw new Exception("Car not found.");
        }

        // Check if the car is available and the booking is under processing
        if ($carresult['STATUS'] === 'Available' && $res['BOOK_STATUS'] === 'UNDER PROCESSING') {
            // Update the booking to approved
            $stmt3 = mysqli_prepare($con, "UPDATE booking SET BOOK_STATUS = 'APPROVED' WHERE BOOK_ID = ?");
            mysqli_stmt_bind_param($stmt3, 'i', $bookid);
            mysqli_stmt_execute($stmt3);

            // Update the car status to 'On rental'
            $stmt4 = mysqli_prepare($con, "UPDATE cars SET STATUS = 'On rental' WHERE CAR_ID = ?");
            mysqli_stmt_bind_param($stmt4, 'i', $car_id);
            mysqli_stmt_execute($stmt4);

            $_SESSION['success'] = "Booking approved successfully.";
        } elseif ($res['BOOK_STATUS'] === 'RETURNED') {
            $_SESSION['error'] = "Cannot approve a returned booking.";
            throw new Exception("Cannot approve a returned booking.");
        } else {
            $_SESSION['error'] = "Car not available for booking or booking is not under processing.";
            throw new Exception("Car not available for booking or booking is not under processing.");
        }

        // Commit the changes if everything is fine
        mysqli_commit($con);
    } catch (Exception $e) {
        mysqli_rollback($con); // An exception has occurred, rollback any changes
    }
} else {
    $_SESSION['error'] = "No booking ID provided or invalid ID.";
}

header("Location: adminbook.php"); // Redirect to the booking page
exit();
