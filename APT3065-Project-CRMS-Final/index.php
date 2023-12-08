<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAR RENTAL</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .dropdown-arrow::after {
            content: '';
            display: inline-block;
            width: 0.5em;
            height: 0.5em;
            border-right: 2px solid white;
            border-bottom: 2px solid white;
            transform: rotate(45deg);
            margin-left: 0.5em;
            transition: transform 0.3s ease;
        }

        .group:hover .dropdown-arrow::after {
            transform: rotate(-135deg);
        }
    </style>
    <!-- SwiperJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</head>

<body class="bg-gray-100">
    <header>
        <nav class="bg-gray-900 p-4">
            <div class="container mx-auto flex justify-center items-center">
                <div class="flex justify-between items-center w-full max-w-6xl">
                    <a class="text-white text-xl font-semibold" href="images/logo.png">CRMS</a>
                    <div class="hidden md:flex space-x-5">
                        <a class="text-gray-300 hover:text-white" href="#">Home</a>
                        <a class="text-gray-300 hover:text-white" href="aboutus.html">About</a>
                        <a class="text-gray-300 hover:text-white" href="#">Services</a>
                        <a class="text-gray-300 hover:text-white" href="contactus.html">Contact</a>
                        <!-- Updated Login Button with Dropdown Arrow -->
                        <div class="group inline-block relative">
                            <button class="text-gray-300 hover:text-white focus:text-white focus:outline-none flex items-center dropdown-arrow">
                                Login
                            </button>
                            <div class="absolute hidden group-hover:block bg-gray-700 text-gray-200 pt-1 w-48 z-20 rounded-md shadow-lg">
                                <a class="flex items-center px-4 py-2 text-sm hover:bg-gray-800" href="adminlogin.php">
                                    <span class="mr-2">&#128273;</span> Admin Login <!-- Unicode padlock symbol -->
                                </a>
                                <a class="flex items-center px-4 py-2 text-sm hover:bg-gray-800" href="clientlogin.php">
                                    <span class="mr-2">&#128100;</span> Client Login <!-- Unicode person symbol -->
                                </a>
                            </div>
                        </div>
                        <a class="text-gray-300 hover:text-white" href="register.php">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>


    </header>

    <main>

        <!-- Tailwind Hero Section -->
        <section class="relative bg-cover bg-center" style="background-image: url('images/IMG-6561213b4cc373.24731337.jpg'); height: 85vh;">
            <div class="absolute inset-0 bg-black opacity-70"></div>
            <div class="container mx-auto text-center flex flex-col justify-center items-center h-full relative z-10">
                <h1 class="text-4xl font-bold text-white">Find, book, rent a car—quick and super easy!</h1>
                <p class="text-xl text-gray-300 mt-4">Streamline your car rental experience with our effortless booking process.</p>
                <a href="register.php" class="mt-5 inline-block bg-blue-500 text-white text-lg px-6 py-3 rounded shadow-lg hover:bg-blue-700 transition duration-300">Explore Cars</a>
            </div>
        </section>


        <!-- Car Showcase Section with Triple Slider -->
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-semibold text-center">Our Cars</h2>
                <div class="swiper mySwiper mt-6">
                    <div class="swiper-wrapper">
                        <!-- Swiper slides with car details -->
                        <div class="swiper-slide">
                            <img src="images/1.jpg" alt="Car 1">
                        </div>
                        <div class="swiper-slide">
                            <img src="images/202 Black_1.png" alt="Car 2">
                        </div>
                        <div class="swiper-slide">
                            <img src="images/6137bcd949456.webp" alt="Car 3">
                        </div>
                        <!-- ... more slides -->
                        <div class="swiper-slide">
                            <img src="images/IMG-656997deeb31c5.24039195.jpg" alt="Car 4">
                        </div>

                        <div class="swiper-slide">
                            <img src="images/IMG-6561213b4cc373.24731337.jpg" alt="Car 5">
                        </div>

                        <div class="swiper-slide">
                            <img src="images/IMG-6566df12ccd0a9.55676028.jpg" alt="Car 6">
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <style>
            .swiper {
                width: 90%;
                padding-top: 80px;
                /* Adjust padding if needed */
                padding-bottom: 80px;
            }

            .swiper-slide {
                background-position: center;
                background-size: cover;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 650px;
                /* Card width */
                height: 400px;
                /* Card height */
                margin: auto;
                /* Centers the slide if the swiper-wrapper is larger than the sum of slides */
                /* Optional shadow */
                box-shadow: 2 4px 8px rgba(0, 0, 0, 0.15);
                border-radius: 8px;
                /* Optional: for rounded corners */
            }

            .swiper-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* Ensures the image covers the slide */
                border-radius: 8px;
                /* Optional: for rounded corners */
            }

            /* Adjust the scale and z-index for the active slide */
            .swiper-slide-active {
                transform: scale(1.05);
                /* Slightly larger scale for active slide */
                z-index: 1;
                /* Ensures active slide is above others */
            }
        </style>






    </main>








    <footer>
        <div class="container text-center">
            <p>&copy; 2023</p>
        </div>
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const loginButton = document.querySelector('.group button');
        const dropdownMenu = document.querySelector('.group .absolute');

        loginButton.addEventListener('click', (event) => {
            dropdownMenu.classList.toggle('hidden');
            event.stopPropagation();
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', (e) => {
            if (!loginButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });


    var swiper = new Swiper('.mySwiper', {
        effect: 'coverflow',
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 100,
            modifier: 2,
            slideShadows: true,
        },
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>









</html>