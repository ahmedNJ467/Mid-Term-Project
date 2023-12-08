<?php
require_once('connection.php');

// SQL query to sum up daily revenue using book_date
$dailyRevenueQuery = "SELECT DATE(b.book_date) as date, SUM(p.price) as daily_total 
                      FROM payment p 
                      JOIN booking b ON p.BOOK_ID = b.BOOK_ID 
                      GROUP BY DATE(b.book_date)";
$dailyRevenueResult = mysqli_query($con, $dailyRevenueQuery);

$dailyRevenues = [];

while ($row = mysqli_fetch_assoc($dailyRevenueResult)) {
    $dailyRevenues[$row['date']] = $row['daily_total'];
}

// SQL query to sum up monthly revenue using book_date
$monthlyRevenueQuery = "SELECT YEAR(b.book_date) as year, MONTH(b.book_date) as month, SUM(p.price) as monthly_total 
                        FROM payment p 
                        JOIN booking b ON p.BOOK_ID = b.BOOK_ID 
                        GROUP BY YEAR(b.book_date), MONTH(b.book_date)";
$monthlyRevenueResult = mysqli_query($con, $monthlyRevenueQuery);

$monthlyRevenues = [];

while ($row = mysqli_fetch_assoc($monthlyRevenueResult)) {
    $monthYear = $row['year'] . '-' . str_pad($row['month'], 2, '0', STR_PAD_LEFT); // Format as "YYYY-MM"
    $monthlyRevenues[$monthYear] = $row['monthly_total'];
}

// Close the database connection
mysqli_close($con);

// Convert data to JSON format
header('Content-Type: application/json');
echo json_encode([
    'dailyRevenues' => $dailyRevenues,
    'monthlyRevenues' => $monthlyRevenues
]);
