<!doctype html>
<html>

<head>
	<title>Feedback Form</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
	<link rel="stylesheet" href="Stylesheet.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
	body {
		background-image: url('Home%20page%20pics/background1.jpeg');
		background-repeat: no-repeat;
		background-attachment: fixed;
	}
</style>

<body class="bg-gray-400 font-sans">

	<?php
	require_once('../connection.php');
	session_start();
	$email = $_SESSION['email'];

	$userQuery = "SELECT FNAME, LNAME FROM users WHERE EMAIL = '$email'";
	$userResult = mysqli_query($con, $userQuery);
	$userData = mysqli_fetch_assoc($userResult);
	$userName = $userData['FNAME'] . ' ' . $userData['LNAME'];

	$feedbackMessage = ""; // Initialize an empty feedback message
	$feedbackType = ""; // Type of feedback ('success' or 'error')

	if (isset($_POST['submit'])) {
		$comment = mysqli_real_escape_string($con, $_POST['comment']);
		$sql = "INSERT INTO feedback (EMAIL, COMMENT) VALUES ('$email', '$comment')";

		if (mysqli_query($con, $sql)) {
			// Success message
			$feedbackMessage = "Feedback Sent Successfully!! THANK YOU!!";
			$feedbackType = "success";
		} else {
			// Error message
			$feedbackMessage = "Sorry, there was an error sending your feedback.";
			$feedbackType = "error";
		}
	}
	?>

	<nav class="bg-gray-900 text-white p-4">
		<div class="container mx-auto flex justify-between items-center">
			<a class="text-xl font-bold" href="#">CRMS</a>
			<div class="flex items-center space-x-4">
				<!-- Update href attributes with correct paths -->
				<a class="hover:text-gray-300" href="../cardetails.php">Home</a>
				<a class="hover:text-gray-300" href="../bookinstatus.php">Booking Status</a>
				<a class="hover:text-gray-300" href="../feedback/Feedbacks.php">Feedback</a>
				<a class="hover:text-gray-300" href="../index.php">Logout</a>
			</div>
			<div class="flex items-center ml-6">
				<img src="../images/profile.png" class="h-8 w-8 rounded-full mr-2" alt="Profile">
				Hello, <?php echo $userName; ?>!
			</div>
		</div>
	</nav>
	<!-- Feedback message banner -->
	<?php if (!empty($feedbackMessage)) : ?>
		<div class="mx-auto max-w-lg my-4">
			<div class="bg-<?php echo $feedbackType === 'success' ? 'green' : 'red'; ?>-100 border border-<?php echo $feedbackType === 'success' ? 'green' : 'red'; ?>-400 text-<?php echo $feedbackType === 'success' ? 'green' : 'red'; ?>-700 px-4 py-3 rounded relative" role="alert">
				<span class="block sm:inline"><?php echo $feedbackMessage; ?></span>
			</div>
		</div>
	<?php endif; ?>

	<div class="container mx-auto px-10 pt-3">
		<div class="flex flex-wrap justify-center">
			<div class="w-full lg:w-2/3">
				<div class="h-80 bg-white rounded-lg shadow-lg mb-2 flex justify-center items-center">
					<!-- Image frame -->
					<img src="../images/customer-satisfaction-scale.jpg" alt="Descriptive Alt Text" class="max-h-64 max-w-full object-contain" />
				</div>

				<form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
					<div class="mb-4">
						<label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
						<input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Full name" required />
					</div>
					<div class="mb-4">
						<label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
						<input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Email" required />
					</div>
					<div class="mb-4">
						<label class="block text-gray-700 text-sm font-bold mb-2" for="comment">Comments</label>
						<textarea name="comment" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Message" required></textarea>
					</div>
					<input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" id="btn" name="submit" value="SUBMIT">
				</form>
			</div>
		</div>
	</div>


</body>

</html>