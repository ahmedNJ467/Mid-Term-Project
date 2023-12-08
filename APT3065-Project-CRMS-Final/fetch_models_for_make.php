<?php
require_once('connection.php');

$make = isset($_GET['make']) ? mysqli_real_escape_string($con, $_GET['make']) : '';

if (!empty($make)) {
    $query = "SELECT DISTINCT Model FROM cars WHERE Make = '$make'";
    $result = mysqli_query($con, $query);

    $models = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $models[] = $row['Model'];
    }

    echo json_encode(['models' => $models]);
} else {
    echo json_encode(['models' => []]);
}
