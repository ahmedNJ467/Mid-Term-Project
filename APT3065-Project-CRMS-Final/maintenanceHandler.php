<?php
require_once('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $carId = $_POST['car_id'];
    $carName = $_POST['CarName'];
    $serviceName = $_POST['ServiceName']; // Use 'name' from the form
    $description = $_POST['description'];

    // Update car status to "In Maintenance"
    $updateStatusQuery = "UPDATE cars SET STATUS = 'In Maintenance' WHERE CAR_ID = '$carId'";
    mysqli_query($con, $updateStatusQuery);

    $_SESSION['maintenance_records'][] = [
        'car_id' => $carId,
        'CarName' => $carName, // Store the car name here
        'ServiceName' => $serviceName,
        'description' => $description
    ];



    header("Location: adminvehicle.php"); // Adjust the redirect as per your application flow
    exit;
}
