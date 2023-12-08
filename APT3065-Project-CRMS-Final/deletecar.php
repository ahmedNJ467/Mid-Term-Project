<?php
session_start();
require_once('connection.php');

// Check if 'id' is set in GET request and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $carId = $_GET['id'];

    // Prepare statement to prevent SQL injection
    if ($stmt = $con->prepare("DELETE FROM cars WHERE CAR_ID = ?")) {
        $stmt->bind_param("i", $carId); // 'i' specifies the variable type => 'integer'

        // Execute query
        $stmt->execute();

        // Check if delete was successful
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Car deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting car";
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing statement";
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

// Redirect to adminvehicle.php
header('Location: adminvehicle.php');
exit();



