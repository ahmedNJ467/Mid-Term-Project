<?php
require_once('connection.php');

// Query to fetch distinct makes
$makeQuery = "SELECT DISTINCT Make FROM cars WHERE Make IS NOT NULL AND Make != ''";
$makeResult = mysqli_query($con, $makeQuery);

$makes = [];
while ($row = mysqli_fetch_assoc($makeResult)) {
    $makes[] = $row['Make'];
}

// Query to fetch distinct models
$modelQuery = "SELECT DISTINCT Model FROM cars WHERE Model IS NOT NULL AND Model != ''";
$modelResult = mysqli_query($con, $modelQuery);

$models = [];
while ($row = mysqli_fetch_assoc($modelResult)) {
    $models[] = $row['Model'];
}

// Return the results as a JSON object
echo json_encode(['makes' => $makes, 'models' => $models]);
