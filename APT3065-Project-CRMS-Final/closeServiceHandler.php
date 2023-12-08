<?php
require_once('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['car_id'])) {
    $carId = $_POST['car_id'];

    // Update car status to "Available"
    $updateStatusQuery = "UPDATE cars SET STATUS = 'Available' WHERE CAR_ID = '$carId'";
    if (mysqli_query($con, $updateStatusQuery)) {
        $_SESSION['success'] = "Service closed successfully";
    } else {
        $_SESSION['error'] = "Error closing service";
    }

    // Optionally, remove the car from the maintenance_records session
    // ... Your code to remove the car from session ...
    // Assuming $carId is the ID of the car to be removed from maintenance
    $carIdToRemove = $_POST['car_id'];

    // Check if the maintenance_records session is set
    if (isset($_SESSION['maintenance_records'])) {
        // Loop through the maintenance records
        foreach ($_SESSION['maintenance_records'] as $key => $record) {
            // Check if the current record's car_id matches the carIdToRemove
            if ($record['car_id'] == $carIdToRemove) {
                // Remove this record from the session
                unset($_SESSION['maintenance_records'][$key]);
                break; // Exit the loop once the record is found and removed
            }
        }
    }

    // Optionally re-index the array if you're relying on numeric indexes
    $_SESSION['maintenance_records'] = array_values($_SESSION['maintenance_records']);

    // Continue with the rest of your script

    if (mysqli_query($con, $updateStatusQuery)) {
        $_SESSION['success'] = "Service closed successfully!";
    } else {
        $_SESSION['error'] = "Error closing service!";
    }

    header("Location: adminvehicle.php"); // Redirect back to the vehicle page
    exit;
}
