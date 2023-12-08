<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('connection.php');

    // Retrieve the image details
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png", "webp", "svg");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = 'images/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            // Retrieve form data
            $carname = mysqli_real_escape_string($con, $_POST['carname']);
            $ftype = mysqli_real_escape_string($con, $_POST['ftype']);
            $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
            $price = mysqli_real_escape_string($con, $_POST['price']);
            $make = mysqli_real_escape_string($con, $_POST['make']); // New
            $model = mysqli_real_escape_string($con, $_POST['model']); // New

            // Insert into the cars table
            $query = "INSERT INTO cars (CAR_NAME, FUEL_TYPE, CAPACITY, PRICE, CAR_IMG, STATUS, Make, Model) VALUES ('$carname', '$ftype', $capacity, $price, '$new_img_name', 'Available', '$make', '$model')";
            $res = mysqli_query($con, $query);

            if ($res) {
                $_SESSION['success'] = "New car added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add new car";
            }
        } else {
            $_SESSION['error'] = "Cannot upload this type of image";
        }
    } else {
        $_SESSION['error'] = "An unknown error occurred";
    }

    header("Location: adminvehicle.php");
    exit;
}
