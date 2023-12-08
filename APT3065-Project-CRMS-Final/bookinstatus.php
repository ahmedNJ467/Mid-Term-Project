<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKING STATUS</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-400 font-sans">
    <?php
    session_start();
    require_once('connection.php');
    $email = $_SESSION['email'];

    $userQuery = "SELECT FNAME, LNAME FROM users WHERE EMAIL = '$email'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $userName = $userData['FNAME'] . " " . $userData['LNAME'];
    ?>

    <nav class="bg-gray-900 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="#">CRMS</a>
            <div class="flex items-center space-x-4">
                <a class="hover:text-gray-300" href="cardetails.php">Home</a>
                <a class="hover:text-gray-300" href="bookinstatus.php">Booking Status</a>
                <a class="hover:text-gray-300" href="feedback/Feedbacks.php">Feedback</a>
                <a class="hover:text-gray-300" href="index.php">Logout</a>
            </div>
            <div class="flex items-center ml-6">
                <img src="images/profile.png" class="h-8 w-8 rounded-full mr-2" alt="Profile">
                Hello, <?php echo $userName; ?>!
            </div>
        </div>
    </nav>

    <div class="flex justify-center mt-10">
        <div class="w-full lg:w-3/4 xl:w-3/4 p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Your Booking History</h2>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Car Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Booking Date
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Duration
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Return Date
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM booking WHERE EMAIL = '$email' ORDER BY BOOK_ID DESC";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $carQuery = "SELECT CAR_NAME FROM cars WHERE CAR_ID = '{$row['CAR_ID']}'";
                        $carResult = mysqli_query($con, $carQuery);
                        $carData = mysqli_fetch_assoc($carResult);
                        $carName = $carData['CAR_NAME'];

                        echo "<tr>
                            <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                <div class='flex items-center'>$carName</div>
                            </td>
                            <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                {$row['BOOK_DATE']}
                            </td>
                            <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                {$row['DURATION']}
                            </td>
                            <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                {$row['RETURN_DATE']}
                            </td>
                            <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                {$row['BOOK_STATUS']}
                            </td>
                          </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
</body>

</html>