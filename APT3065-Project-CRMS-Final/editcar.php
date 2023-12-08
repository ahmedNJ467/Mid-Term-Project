<?php
session_start();
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching and sanitizing input
    $carId = mysqli_real_escape_string($con, $_POST['car_id']);
    $carName = mysqli_real_escape_string($con, $_POST['car_name']);
    $fuelType = mysqli_real_escape_string($con, $_POST['ftype']);
    $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

    // Start building the SQL query
    $query = "UPDATE cars SET CAR_NAME = '$carName', FUEL_TYPE = '$fuelType', CAPACITY = '$capacity', PRICE = '$price'";

    // If a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png", "webp", "svg");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = 'images/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            // Append new image to the update query
            $query .= ", CAR_IMG = '$new_img_name'";
        } else {
            $_SESSION['error'] = "Cannot upload this type of image";
            header("Location: adminvehicle.php");
            exit;
        }
    }

    // Finalize the query with WHERE clause
    $query .= " WHERE CAR_ID = '$carId'";

    // Execute the update query
    if (mysqli_query($con, $query)) {
        $_SESSION['success'] = "Car updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating car: " . mysqli_error($con);
    }

    mysqli_close($con);
    header("Location: adminvehicle.php");
    exit;
}
