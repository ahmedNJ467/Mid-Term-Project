<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script type="text/javascript">
        // Your existing JavaScript
        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function() {
            null
        };
    </script>
</head>

<body class="flex justify-center items-center h-screen bg-gradient-to-r from-gray-700 via-gray-900 to-black text-white">
    <div class="w-full max-w-xs p-6 rounded-lg bg-white/10 backdrop-blur-sm">
        <form class="login-form" method="POST">
            <div class="text-center mb-6">
                <!-- Admin Icon -->
                <i class="fas fa-user-shield text-6xl"></i>
                <h2 class="text-2xl mt-2">Admin Login</h2>
            </div>
            <input type="text" name="adid" placeholder="Enter admin user id" class="w-full p-3 mb-4 rounded border-none focus:ring-2 focus:ring-blue-500 text-gray-800">
            <input type="password" name="adpass" placeholder="Enter admin password" class="w-full p-3 mb-6 rounded border-none focus:ring-2 focus:ring-blue-500 text-gray-800">
            <button type="submit" name="adlog" class="w-full p-3 rounded-lg bg-gradient-to-r from-green-400 via-pink-500 to-purple-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-opacity-50">
                LOGIN
            </button>
        </form>
    </div>
    <!-- PHP Code -->
    <?php
    require_once('connection.php');
    if (isset($_POST['adlog'])) {
        $id = $_POST['adid'];
        $pass = $_POST['adpass'];


        if (empty($id) || empty($pass)) {
            echo '<script>alert("please fill the blanks")</script>';
        } else {
            $query = "select *from admin where ADMIN_ID='$id'";
            $res = mysqli_query($con, $query);
            if ($row = mysqli_fetch_assoc($res)) {
                $db_password = $row['ADMIN_PASSWORD'];
                if ($pass  == $db_password) {

                    // session_start();
                    // $_SESSION['email'] = $email;
                    echo '<script>alert("Welcome ADMINISTRATOR!");</script>';
                    header("location: dashboard.php");
                } else {
                    echo '<script>alert("Enter a proper password")</script>';
                }
            } else {
                echo '<script>alert("enter a proper email")</script>';
            }
        }
    }

    ?>

</body>

</html>