<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAR BOOKING</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.x/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('Home%20page%20pics/background1.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="bg-gray-400 font-sans">
    <!-- ... PHP code ... -->
    <?php

    require_once('connection.php');
    session_start();

    $carid = $_GET['id'];

    $sql = "select *from cars where CAR_ID='$carid'";
    $cname = mysqli_query($con, $sql);
    $email = mysqli_fetch_assoc($cname);

    $value = $_SESSION['email'];
    $sql = "select * from users where EMAIL='$value'";
    $name = mysqli_query($con, $sql);
    $rows = mysqli_fetch_assoc($name);
    $uemail = $rows['EMAIL'];
    $carprice = $email['PRICE'];
    if (isset($_POST['book'])) {

        $bplace = mysqli_real_escape_string($con, $_POST['place']);
        $bdate = date('Y-m-d', strtotime($_POST['date']));;
        $dur = mysqli_real_escape_string($con, $_POST['dur']);
        $phno = mysqli_real_escape_string($con, $_POST['ph']);
        $des = mysqli_real_escape_string($con, $_POST['des']);
        $rdate = date('Y-m-d', strtotime($_POST['rdate']));

        if (empty($bplace) || empty($bdate) || empty($dur) || empty($phno) || empty($des) || empty($rdate)) {
            echo '<script>alert("please fill the place")</script>';
        } else {
            if ($bdate < $rdate) {
                $price = ($dur * $carprice);
                $sql = "insert into booking (CAR_ID,EMAIL,BOOK_PLACE,BOOK_DATE,DURATION,PHONE_NUMBER,DESTINATION,PRICE,RETURN_DATE) values($carid,'$uemail','$bplace','$bdate',$dur,$phno,'$des',$price,'$rdate')";
                $result = mysqli_query($con, $sql);

                if ($result) {

                    $_SESSION['email'] = $uemail;
                    header("Location: payment.php");
                } else {
                    echo '<script>alert("please check the connection")</script>';
                }
            } else {
                echo  '<script>alert("please enter a correct rturn date")</script>';
            }
        }
    }

    ?>
    <?php

    require_once('connection.php');
    $email = $_SESSION['email'];

    $userQuery = "SELECT FNAME, LNAME FROM users WHERE EMAIL = '$email'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $userName = $userData['FNAME'] . " " . $userData['LNAME'];

    // Check if the feedback_success message is set
    if (isset($_SESSION['feedback_success'])) {
        echo '<script>alert("' . $_SESSION['feedback_success'] . '")</script>';
        unset($_SESSION['feedback_success']); // Clear the message after displaying
    }
    ?>

    <!-- Navigation Bar -->
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




    <div class="container mx-auto mt-12">
        <div class="flex justify-center">
            <div class="w-full max-w-xl">
                <div class="bg-white p-8 rounded shadow-md">
                    <h3 class="text-xl text-center font-semibold mb-6">Car Booking</h3>
                    <form id="booking-form" method="POST" class="space-y-4">
                        <div class="flex flex-col">
                            <label for="place" class="mb-2 font-bold text-gray-700">Booking Place</label>
                            <input type="text" class="px-4 py-2 border rounded" id="place" name="place" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="date" class="mb-2 font-bold text-gray-700">Booking Date</label>
                            <input type="date" class="px-4 py-2 border rounded" id="date" name="date" required onchange="calculateReturnDate()">
                        </div>
                        <div class="flex flex-col">
                            <label for="dur" class="mb-2 font-bold text-gray-700">Duration (Days)</label>
                            <input type="number" class="px-4 py-2 border rounded" id="dur" name="dur" min="1" required onchange="calculateReturnDate()">
                        </div>
                        <div class="flex flex-col">
                            <label for="ph" class="mb-2 font-bold text-gray-700">Phone Number</label>
                            <input type="tel" class="px-4 py-2 border rounded" id="ph" name="ph" maxlength="10" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="des" class="mb-2 font-bold text-gray-700">Destination</label>
                            <input type="text" class="px-4 py-2 border rounded" id="des" name="des" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="rdate" class="mb-2 font-bold text-gray-700">Return Date</label>
                            <input type="date" class="px-4 py-2 border rounded" id="rdate" name="rdate" required readonly>
                        </div>
                        <button type="submit" class="w-full mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" name="book">Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ... JavaScript for form ... -->
    <script>
        function calculateReturnDate() {
            var bookingDate = document.getElementById("date").value;
            var duration = document.getElementById("dur").value;
            var returnDateField = document.getElementById("rdate");

            if (bookingDate && duration) {
                var returnDate = new Date(bookingDate);
                returnDate.setDate(returnDate.getDate() + parseInt(duration));
                returnDateField.value = returnDate.toISOString().split('T')[0];
            }
        }

        var today = new Date().toISOString().split('T')[0];
        var maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() + 1);
        maxDate = maxDate.toISOString().split('T')[0];

        document.getElementById("date").setAttribute('min', today);
        document.getElementById("date").setAttribute('max', maxDate);
        document.getElementById("rdate").setAttribute('min', today);
        document.getElementById("rdate").setAttribute('max', maxDate);
    </script>
</body>

</html>