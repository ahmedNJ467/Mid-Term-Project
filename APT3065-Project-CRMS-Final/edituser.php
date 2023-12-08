<?php
session_start();
require_once('connection.php'); // Ensure this points to your actual connection file

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching and sanitizing input
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $lic_num = mysqli_real_escape_string($con, $_POST['lic_num']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);

    // Update query
    $query = "UPDATE users SET FNAME = '$fname', LNAME = '$lname', LIC_NUM = '$lic_num', PHONE_NUMBER = '$phone_number', GENDER = '$gender' WHERE EMAIL = '$email'";

    // Execute the update query
    if (mysqli_query($con, $query)) {
        $_SESSION['success'] = "User updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating user: " . mysqli_error($con);
    }

    // Redirect back to the user management page
    header("Location: adminusers.php");
    exit;
} else {
    // Redirect to the user management page if the script is accessed without a POST request
    header("Location: adminusers.php");
    exit;
}
