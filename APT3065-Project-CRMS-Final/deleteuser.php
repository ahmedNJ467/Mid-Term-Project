<?php
session_start();
require_once('connection.php');

// Check if 'id' is set in GET request and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $email = $_GET['id'];

    // Prepare statement to prevent SQL injection
    if ($stmt = $con->prepare("DELETE FROM users WHERE EMAIL = ?")) {
        $stmt->bind_param("s", $email); // 's' specifies the variable type => 'string'

        // Execute query
        $stmt->execute();

        // Check if delete was successful
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting user";
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing statement";
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

// Redirect to adminusers.php
header('Location: adminusers.php');
exit();
