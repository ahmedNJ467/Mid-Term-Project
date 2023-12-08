<?php

require_once('connection.php');
session_start();
$email  =   $_SESSION['email'];

$sql = "select *from booking where EMAIL='$email' order by BOOK_ID DESC ";
$cname = mysqli_query($con, $sql);
$email = mysqli_fetch_assoc($cname);
$bid = $email['BOOK_ID'];
$_SESSION['bid'] = $bid;

if (isset($_POST['pay'])) {
  $cardno = mysqli_real_escape_string($con, $_POST['cardno']);
  $exp = mysqli_real_escape_string($con, $_POST['exp']);
  $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
  $price = $email['PRICE'];
  if (empty($cardno) || empty($exp) ||  empty($cvv)) {
    echo '<script>alert("please fill the place")</script>';
  } else {
    $sql2 = "insert into payment (BOOK_ID,CARD_NO,EXP_DATE,CVV,PRICE) values($bid,'$cardno','$exp',$cvv,$price)";
    $result = mysqli_query($con, $sql2);
    if ($result) {
      header("Location: psucess.php");
    }
  }
}
// Check if the session variable is set before using it
if (isset($_SESSION['bid'])) {
  $bid = $_SESSION['bid'];

  if (isset($_POST['cancelnow'])) {
    // Your SQL logic
    $del = mysqli_query($con, "delete from booking where BOOK_ID = '$bid' order by BOOK_ID DESC limit 1");
    echo "<script>window.location.href='cardetails.php';</script>";
  }
} else {
  // Handle the case where $_SESSION['bid'] is not set
  // For example, redirect to another page or show an error message
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Secure Payment</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
</head>

<body class="bg-gray-100">

  <!-- Payment Form Container -->
  <div class="container mx-auto px-4 h-screen flex flex-col justify-center">

    <!-- Payment Card -->
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
      <h2 class="text-2xl font-semibold text-gray-700 text-center">Secure Payment</h2>
      <p class="text-gray-600 text-sm text-center mt-2">
        <i class="fas fa-lock text-green-500"></i> Your transaction is secure with us.
      </p>

      <form method="POST" class="mt-8">
        <!-- Card Number -->
        <div class="mb-4">
          <label for="cardNumber" class="block text-sm font-medium text-gray-700">Card Number</label>
          <input type="text" id="cardNumber" name="cardno" placeholder="xxxx-xxxx-xxxx-xxxx" required="required" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" maxlength="16" />
        </div>

        <!-- Expiry Date and CCV -->
        <div class="mb-4 grid grid-cols-2 gap-4">
          <div>
            <label for="cardExpiry" class="block text-sm font-medium text-gray-700">Expiry Date</label>
            <input type="text" id="cardExpiry" name="exp" placeholder="MM/YY" required="required" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" maxlength="5" />
          </div>
          <div>
            <label for="cardCcv" class="block text-sm font-medium text-gray-700">CCV</label>
            <input type="password" id="cardCcv" name="cvv" placeholder="xxx" required="required" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" maxlength="3" />
          </div>
        </div>

        <!-- Payment Button -->
        <div class="mt-6">
          <button type="submit" name="pay" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Complete Payment</button>
        </div>
      </form>


      <!-- Cancel Booking Link -->
      <div class="text-center mt-6">
        <button onclick="openModal()" class="text-gray-500 hover:text-gray-600">Cancel and return</button>
      </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div id="cancelModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal Content -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Cancel Booking</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Are you sure you want to cancel your booking?</p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <form method="POST">
              <button type="submit" name="cancelnow" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Cancel Now</button>
            </form>
            <button onclick="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Go Back</button>
          </div>
        </div>
      </div>
    </div>




    <script>
      function openModal() {
        document.getElementById('cancelModal').classList.remove('hidden');
      }

      function closeModal() {
        document.getElementById('cancelModal').classList.add('hidden');
      }
    </script>
</body>

</html>