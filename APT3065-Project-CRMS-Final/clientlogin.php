<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login - CAR RENTAL</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .login-background {
            background-image: url('images/1.jpg');
            background-size: cover;
            background-position: center;
        }

        .dark-overlay {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center">
    <div class="login-background absolute inset-0 z-0"></div>
    <!-- Dark Overlay -->
    <div class="dark-overlay absolute inset-0 z-10"></div>
    <div class="form-container rounded-lg p-6 max-w-lg w-full z-20">


        <!-- Client Login Icon -->
        <div class="text-center mb-4">
            <i class="fas fa-user-circle text-6xl"></i> <!-- You can choose any other icon -->
        </div>
        <h2 class="text-3xl text-center text-gray-900 font-bold mb-6">Client Login</h2>




        <?php
        session_start();
        require_once('connection.php');

        $error_message = ""; // Initialize an empty error message

        if (isset($_POST['login'])) {
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $pass = mysqli_real_escape_string($con, $_POST['pass']);

            if (empty($email) || empty($pass)) {
                $error_message = "Please fill the blanks";
            } else {
                $query = "SELECT * FROM users WHERE EMAIL='$email'";
                $res = mysqli_query($con, $query);

                if (!$res) {
                    $error_message = "Database query failed: " . mysqli_error($con);
                } else if ($row = mysqli_fetch_assoc($res)) {
                    $db_password = $row['PASSWORD'];
                    if (md5($pass) == $db_password) {
                        $_SESSION['email'] = $email;
                        header("location: cardetails.php");
                        exit;
                    } else {
                        $error_message = "Incorrect password";
                    }
                } else {
                    $error_message = "Email not found";
                }
            }
        }
        ?>


        <!-- Alert banners -->
        <?php if (!empty($error_message)) : ?>
            <div id="error-banner" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Error</p>
                <p><?php echo htmlspecialchars($error_message); ?></p>
            </div>
        <?php endif; ?>





        <form method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm text-base focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter email">
            </div>
            <div>
                <label for="pass" class="block text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="pass" id="pass" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm text-base focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Password">
            </div>
            <button type="submit" name="login" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Login
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-900">
            Don't have an account? <a href="register.php" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</a>
        </p>
        <!-- Social Links -->
        <div class="flex justify-center mt-4">
            <a href="https://www.facebook.com" class="text-blue-600 mx-2">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.twitter.com" class="text-blue-400 mx-2">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.linkedin.com" class="text-blue-700 mx-2">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>
</body>

</html>