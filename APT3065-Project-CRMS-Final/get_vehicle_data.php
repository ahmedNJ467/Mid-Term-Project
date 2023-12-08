<?php
require_once('connection.php');

// Initialize default status data
$statusData = [
    'Available' => 0,
    'On Rental' => 0,
    'In Maintenance' => 0,
];

try {
    // Query to get vehicle statuses
    $query = "SELECT STATUS, COUNT(*) as count FROM cars GROUP BY STATUS";
    $result = mysqli_query($con, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Make sure the status from the database matches your expected statuses
            switch ($row['STATUS']) {
                case 'Available':
                case 'On Rental':
                case 'In Maintenance':
                    $statusData[$row['STATUS']] = (int)$row['count'];
                    break;
                default:
                    // Handle unexpected status
                    break;
            }
        }
    } else {
        throw new Exception('Query failed to execute.');
    }
} catch (Exception $e) {
    // Log the error or send it to an administrator
    error_log($e->getMessage());
    // Optionally set the $statusData to some error value if needed
}

header('Content-Type: application/json');
echo json_encode($statusData);
