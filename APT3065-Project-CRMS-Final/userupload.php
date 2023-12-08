<?php
session_start();

require_once('connection.php');

function uploadFile($file, $uploadPath)
{
    $img_name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $error = $file['error'];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png", "webp", "svg"); // Allowed extensions

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = $uploadPath . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            return $new_img_name;
        } else {
            $_SESSION['error'] = "Cannot upload this type of file.";
            header("Location: register.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "An error occurred during file upload: Error Code $error";
        header("Location: register.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize file names
    $nationalIdFileName = '';
    $driversLicenseFileName = '';

    // Handle National ID upload
    if (isset($_FILES['nationalid'])) {
        $nationalIdUploadPath = 'userupload/nationalid/';
        $nationalIdFileName = uploadFile($_FILES['nationalid'], $nationalIdUploadPath);

        if (!$nationalIdFileName) {
            exit; // Error message is already set within uploadFile function
        }
    }

    // Handle Driver's License upload
    if (isset($_FILES['driverslicense'])) {
        $driversLicenseUploadPath = 'userupload/driverslicense/';
        $driversLicenseFileName = uploadFile($_FILES['driverslicense'], $driversLicenseUploadPath);

        if (!$driversLicenseFileName) {
            exit; // Error message is already set within uploadFile function
        }
    }

    // Save the user data and file names in the database
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $ph = mysqli_real_escape_string($con, $_POST['ph']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']); // Fetch the password
    $hashedPass = md5($pass); // Hash the password

    $sql = "INSERT INTO users (FNAME, LNAME, EMAIL, PHONE_NUMBER, NATIONALID_FILENAME, DRIVERSLICENSE_FILENAME, PASSWORD) VALUES ('$fname', '$lname', '$email', '$ph', '$nationalIdFileName', '$driversLicenseFileName', '$hashedPass')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: clientlogin.php"); // Redirect to login page
    } else {
        $_SESSION['error'] = "There was an error processing your registration: " . mysqli_error($con);
        header("Location: register.php"); // Redirect back to the registration page
    }
}
