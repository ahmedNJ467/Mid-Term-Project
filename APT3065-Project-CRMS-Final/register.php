<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration - CAR RENTAL</title>
  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900">
  <?php
  require_once('connection.php');
  require_once('userupload.php'); // Include the userupload.php file


  if (isset($_POST['regs'])) {
    // Extract form data
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $ph = mysqli_real_escape_string($con, $_POST['ph']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);
    $cpass = mysqli_real_escape_string($con, $_POST['cpass']);
    $hashedPass = md5($pass);

    // Handle file uploads
    $nationalIdFilename = uploadFile($_FILES['nationalid'], 'userupload/nationalid/');
    $driversLicenseFilename = uploadFile($_FILES['driverslicense'], 'userupload/driverslicense/');

    if ($nationalIdFilename && $driversLicenseFilename) {
      if (empty($fname) || empty($lname) || empty($email) || empty($ph) || empty($pass)) {
        echo '<script>alert("Please fill in all the required fields.")</script>';
      } elseif ($pass !== $cpass) {
        echo '<script>alert("Passwords did not match.")</script>';
      } else {
        $sql2 = "SELECT * FROM users WHERE EMAIL='$email'";
        $res = mysqli_query($con, $sql2);
        if (mysqli_num_rows($res) > 0) {
          echo '<script>alert("Email already exists, press OK for login.")</script>';
          echo '<script>window.location.href = "index.php";</script>';
        } else {
          $sql = "INSERT INTO users (FNAME, LNAME, EMAIL, PHONE_NUMBER, PASSWORD, NATIONALID_FILENAME, DRIVERSLICENSE_FILENAME) VALUES ('$fname', '$lname', '$email', '$ph', '$hashedPass', '$nationalIdFilename', '$driversLicenseFilename')";
          $result = mysqli_query($con, $sql);
          if ($result) {
            echo '<script>alert("Registration successful, press OK to login.")</script>';
            echo '<script>window.location.href = "index.php";</script>';
          } else {
            echo '<script>alert("There was an error processing your registration, please try again.")</script>';
          }
        }
      }
    } else {
      echo '<script>alert("There was an error uploading your files.")</script>';
    }
  }

  ?>



  <div class="container mx-auto mt-3 p-3 bg-black bg-opacity-30 rounded-lg shadow-xl max-w-1xl lg:max-w-5xl"> <!-- Responsive container -->
    <div class="flex flex-col lg:flex-row justify-center -mx-2"> <!-- Responsive flex layout -->
      <!-- Image container -->
      <div class="w-full lg:w-1/2 flex items-center justify-center overflow-hidden rounded-lg mb-4 lg:mb-0">
        <img src="images/6137bcd949456.webp" alt="Descriptive Alt Text" class="w-full h-full object-contain rounded-lg shadow-lg">
      </div>

      <!-- Form container -->
      <div class="w-full lg:w-1/2">
        <div class="bg-white bg-opacity-75 shadow-md rounded-lg px-4 py-6 mb-4 border border-gray-200">
          <!-- Form content -->

          <div class="mb-8">
            <h3 class="text-gray-700 text-center font-bold text-xl md:text-2xl lg:text-3xl">Sign Up</h3>
          </div>

          <form id="registrationForm" method="POST" action="register.php" enctype="multipart/form-data">
            <!-- Name Fields -->
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label for="fname" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">First Name</label>
                <input type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="fname" name="fname" placeholder="Enter Your First Name" required>
              </div>
              <div class="w-full md:w-1/2 px-3">
                <label for="lname" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Last Name</label>
                <input type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="lname" name="lname" placeholder="Enter Your Last Name" required>
              </div>
            </div>

            <!-- Email Field -->
            <div class="mb-4 px-3">
              <label for="email" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Email</label>
              <input type="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="email" name="email" placeholder="Enter Valid Email" required>
            </div>



            <!-- Phone Number Field -->
            <div class="mb-4 px-3">
              <label for="ph" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Phone Number</label>
              <input type="tel" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="ph" name="ph" placeholder="Enter Your Phone Number" required>
            </div>
            <!-- National ID Upload Field -->
            <div class="mb-4 px-3">
              <label for="national-id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">National ID</label>
              <input type="file" id="national-id" name="nationalid" class="block w-full text-sm text-gray-700 py-2 px-4 border rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" accept=".jpg, .jpeg, .png">
            </div>

            <!-- Driver's License Upload Field -->
            <div class="mb-4 px-3">
              <label for="drivers-license" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Driver's License</label>
              <input type="file" id="drivers-license" name="driverslicense" class="block w-full text-sm text-gray-700 py-2 px-4 border rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" accept=".jpg, .jpeg, .png">
            </div>

            <!-- Password Field -->
            <div class="mb-4 px-3">
              <label for="pass" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Password</label>
              <input type="password" id="psw" name="pass" placeholder="Enter Password" required class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            </div>
            <!-- Message Tooltip -->
            <div id="message" class="absolute hidden p-4 mt-2 bg-gray-100 rounded-md shadow-lg z-10">
              <h3 class="text-gray-700 font-semibold mb-2">Password must contain the following</h3>
              <p id="letter" class="text-gray-700 mb-1">A <b>lowercase</b> letter</p>
              <p id="capital" class="text-gray-700 mb-1">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="text-gray-700 mb-1">A <b>number</b></p>
              <p id="length" class="text-gray-700 mb-1">Minimum <b>8 characters</b></p>
            </div>
            <!-- Confirm Password Field -->
            <div class="mb-4 px-3">
              <label for="cpsw" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Confirm Password</label>
              <input type="password" id="cpsw" name="cpass" placeholder="Confirm Password" required class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            </div>




            <!-- Register Button -->
            <div class="flex items-center justify-between px-7">
              <button type="submit" name="regs" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
            </div>

            <div class="text-center text-gray-700 text-sm">
              Already have an account? <a href="clientlogin.php" class="text-blue-500 hover:text-blue-800">Log in</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>




  <script>
    var myInput = document.getElementById("psw");
    var confirmMyInput = document.getElementById("cpsw");
    var message = document.getElementById("message");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message tooltip
    myInput.onfocus = function() {
      message.classList.remove('hidden');
    }

    // When the user clicks outside of the password field, hide the message tooltip
    myInput.onblur = function() {
      message.classList.add('hidden');
    }
    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if (myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("text-red-600");
        letter.classList.add("text-green-600");
      } else {
        letter.classList.remove("text-green-600");
        letter.classList.add("text-red-600");
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if (myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("text-red-600");
        capital.classList.add("text-green-600");
      } else {
        capital.classList.remove("text-green-600");
        capital.classList.add("text-red-600");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if (myInput.value.match(numbers)) {
        number.classList.remove("text-red-600");
        number.classList.add("text-green-600");
      } else {
        number.classList.remove("text-green-600");
        number.classList.add("text-red-600");
      }

      // Validate length
      if (myInput.value.length >= 8) {
        length.classList.remove("text-red-600");
        length.classList.add("text-green-600");
      } else {
        length.classList.remove("text-green-600");
        length.classList.add("text-red-600");
      }
    }
    // Check if passwords match
    confirmMyInput.onkeyup = function() {
      if (myInput.value === confirmMyInput.value) {
        confirmMyInput.classList.remove('border-red-500');
        confirmMyInput.classList.add('border-green-500');
      } else {
        confirmMyInput.classList.remove('border-green-500');
        confirmMyInput.classList.add('border-red-500');
      }
    }
  </script>
  <script>
    function onlyNumberKey(evt) {
      // Only ASCII character in that range allowed
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
      return true;
    }
  </script>

  <!-- Tailwind JS for any interactive components like dropdowns (if needed) -->
  <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.js"></script>
</body>

</html>