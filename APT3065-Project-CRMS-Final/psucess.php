<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Success Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .custom-circle {
      clip-path: circle(50%);
    }
  </style>
</head>

<body class="bg-cover bg-center" style="background-image: url('images/ps.png')">

  <div class="flex justify-center items-center h-screen">
    <div class="bg-white p-6 md:p-12 rounded-lg shadow-xl text-center max-w-sm md:max-w-md">
      <div class="custom-circle bg-green-100 h-24 w-24 md:h-32 md:w-32 flex items-center justify-center mx-auto">
        <svg class="text-green-500 w-12 md:w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h1 class="text-green-500 font-bold text-3xl md:text-4xl mt-4">Success</h1>
      <p class="text-gray-700 mt-4 text-lg md:text-xl">We received your rental request; we'll be in touch shortly!</p>
      <a href="cardetails.php" class="inline-block mt-8 bg-blue-500 text-white font-bold py-2 px-6 rounded hover:bg-orange-600 transition duration-200">
        Search Cars
      </a>
    </div>
  </div>

</body>

</html>