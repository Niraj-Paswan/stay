<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
  // If not logged in, redirect to login.php
  header("Location: login.php");
  exit();
}

// Fetch the logged-in user's userID from the session
$userID = $_SESSION["userID"];
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StayEase | Home page</title>
  <link href="../assets/css/styles.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <!-- Google fonts Link -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <!-- Font Awsome Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      /* Prevent horizontal scrolling */
    }

    /* Animation styles */
    .opacity-0 {
      opacity: 0;
    }

    .opacity-100 {
      opacity: 1;
    }

    .scale-95 {
      transform: scale(0.95);
    }

    .scale-100 {
      transform: scale(1);
    }

    #dropdown-menu {
      transition: transform 0.2s ease-out, opacity 0.2s ease-out;
    }

    /* Container for the icon to position it properly */
    .icon-container {
      position: absolute;
      left: -24px;
      /* Adjust this value to move the icon over the line */
      top: 50%;
      /* Center it vertically */
      transform: translateY(-50%);
      width: 36px;
      /* Width of the icon container */
      height: 36px;
      /* Height of the icon container */
      background-color: #e0e0e0;
      /* Background color of the circle */
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Initial hidden state */
    .scroll-animation {
      opacity: 0;
      /* Initially hidden */
      transform: translateY(30px);
      /* Move slightly down */
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
      /* Smooth transition */
    }

    /* Visible state */
    .scroll-animation.visible {
      opacity: 1;
      transform: translateY(0);
      /* Move to original position */
    }

    /* Circle Image */
    .scroll-animation img {
      opacity: 0;
      /* Initially hidden */
      transform: scale(0.8);
      /* Smaller size */
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    /* When visible, enlarge and fade in the image */
    .scroll-animation.visible img {
      opacity: 1;
      transform: scale(1);
      /* Return to original size */
    }
  </style>

</head>

<body>
  <!-- Navbar -->
  <nav
    class="mt-2 h-16 border sm:border-[0.5px] flex bg-transparent justify-between items-center rounded-full w-[95%] absolute top-0 left-1/2 transform -translate-x-1/2 z-10 backdrop-blur-lg bg-white/10">

    <!-- navbar content here -->

    <!-- Logo -->
    <a href="#" id="brands" class="font-Nrj-fonts font-semibold text-md flex items-center ml-2">
      <img class="max-w-10 max-h-44 ml-5" src="../assets/img/stayease logo.svg" alt="" />
      <p class="font-Nrj-fonts ml-2 text-xl text-white">StayEase</p>
    </a>

    <!-- Desktop Navigation -->
    <div id="nav-menu" class="hidden lg:flex gap-16">
      <a class="font-Nrj-fonts text-black text-md font-semibold group inline-block text-center relative" href="#">Home
        <hr
          class="opacity-100 w-[80%] h-1 rounded-full bg-for mx-auto transition-all duration-300 ease-in-out transform scale-x-100 origin-center absolute left-1/2 transform -translate-x-1/2" />
      </a>
      <!-- <a class="font-Nrj-fonts text-white text-md font-semibold group inline-block text-center relative"
        href="#">Property
        <hr
          class="opacity-0 group-hover:opacity-100 w-[80%] h-1 rounded-full bg-for mx-auto transition-all duration-300 ease-in-out transform scale-x-0 group-hover:scale-x-100 origin-center absolute left-1/2 transform -translate-x-1/2" />
      </a> -->
      <a class="font-Nrj-fonts text-md text-white font-semibold group inline-block text-center relative"
        href="nearby.php">Near
        By Property
        <hr
          class="opacity-0 group-hover:opacity-100 w-[80%] h-1 rounded-full bg-for mx-auto transition-all duration-300 ease-in-out transform scale-x-0 group-hover:scale-x-100 origin-center absolute left-1/2 transform -translate-x-1/2" />
      </a>
      <a class="font-Nrj-fonts text-md text-white font-semibold group inline-block text-center relative"
        href="../info/bgcalculator.html">Budget
        Calculator
        <hr
          class="opacity-0 group-hover:opacity-100 w-[80%] h-1 rounded-full bg-for mx-auto transition-all duration-300 ease-in-out transform scale-x-0 group-hover:scale-x-100 origin-center absolute left-1/2 transform -translate-x-1/2" />
      </a>
      <a class="font-Nrj-fonts text-white text-md font-semibold group inline-block text-center relative"
        href="../info/contactus.html">Contact Us
        <hr
          class="opacity-0 group-hover:opacity-100 w-[80%] h-1 rounded-full bg-for mx-auto transition-all duration-300 ease-in-out transform scale-x-0 group-hover:scale-x-100 origin-center absolute left-1/2 transform -translate-x-1/2" />
      </a>
    </div>

    <!-- User Dropdown -->
    <div class="flex flex-row justify-evenly">
      <!-- User Menu -->
      <div class="relative mr-7">
        <button type="button"
          class="relative flex items-center justify-center w-8 h-8 rounded-full bg-blue-700 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
          id="user-menu-button" aria-expanded="false" aria-haspopup="true">
          <span class="sr-only">Open user menu</span>
          <i class="fa-solid fa-user text-white text-lg"></i>
        </button>
        <div id="dropdown-menu"
          class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 transform opacity-0 scale-95 transition duration-300 ease-out group-hover:opacity-100 group-hover:scale-100"
          role="menu" aria-orientation="vertical" tabindex="-1">
          <a href="userinfo.php"
            class="block px-4 py-2 text-sm text-black font-Nrj-fonts hover:bg-gray-100 hover:pl-3 transition-all duration-300"
            role="menuitem">
            Your Profile
          </a>
          <a href="logout.php"
            class="block px-4 py-2 text-sm text-red-600 font-Nrj-fonts hover:bg-gray-100 hover:pl-3 transition-all duration-300"
            role="menuitem">
            Sign Out
            <i class="fa-regular fa-arrow-right-from-bracket ml-20"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Icon -->
    <button class="p-3 lg:hidden" onclick="handleMenu()">
      <i class="fa-solid fa-bars text-black h-5"></i>
    </button>

    <!-- Mobile Navigation -->
    <div id="mobile_men" class="hidden fixed bg-white z-10 md:hidden inset-0 p-3">
      <div id="nav-bar" class="flex justify-between">
        <a href="#" id="brands" class="font-Nrj-fonts font-bold text-lg flex items-center ml-2">
          <img class="object-cover max-w-18 max-h-18" src="../assets/img/stayease logo.svg" alt="Logo" />
        </a>
        <button class="p-3 md:hidden" onclick="handleMenu()">
          <i class="fa-solid fa-xmark text-gray-500 h-5"></i>
        </button>
      </div>

      <!-- Mobile Menu Links -->
      <div class="mt-5">
        <a href="#"
          class="font-Nrj-fonts font-semibold m-3 p-3 hover:bg-gray-100 hover:text-primary rounded-lg block">Home</a>
        <a href="#"
          class="font-Nrj-fonts font-semibold m-3 p-3 hover:bg-gray-100 hover:text-primary rounded-lg block">Property</a>
        <a href="#"
          class="font-Nrj-fonts font-semibold m-3 p-3 hover:bg-gray-100 hover:text-primary rounded-lg block">Near By</a>
        <a href="#"
          class="font-Nrj-fonts font-semibold m-3 p-3 hover:bg-gray-100 hover:text-primary rounded-lg block">Budget
          Calculator</a>
        <a href="login.html"
          class="font-Nrj-fonts font-semibold m-3 p-3 hover:bg-gray-100 hover:text-primary rounded-lg block">Contact
          Us</a>
      </div>

      <!-- Divider -->
      <div class="h-[2px] bg-gray-300"></div>
    </div>
  </nav>

  <!-- Relaxing image with circle -->
  <div class="absolute top-0 left-0 right-0 bottom-0 z-0 flex justify-center items-start">
    <img class="hidden md:block md:w-[1550px] w-full mt-0" src="../assets/img/relaxing-with-headphones.png"
      alt="Person relaxing with headphones" loading="lazy" />
  </div>

  <!-- Main Content Below -->
  <!-- Intro Para -->
  <div class="relative mt-32 flex justify-center items-center text-center flex-col">
    <div class="text-black">
      <h1 class="font-Nrj-fonts font-semibold text-3xl  sm:mb-14 md:text-2xl lg:text-6xl lg:mb-0">
        Welcome to StayEase
      </h1>
    </div>

    <h3
      class="font-Nrj-fonts font-semibold mt-4 text-black text-lg sm:text-xl sm:text-black md:text-2xl md:text-white lg:text-3xl lg:text-white leading-tight">
      Find Your Dream
      <span class="text-for font-semibold text-lg sm:text-xl md:text-2xl lg:text-3xl">
        Room
      </span>
      Today with
      <span class="text-for font-semibold text-lg sm:text-xl md:text-2xl lg:text-3xl">
        Affordability!
      </span>
    </h3>

    <!-- Featured features -->
    <div id="hero-features" class="hidden sm:flex gap-4 my-4">
      <div
        class="w-24 h-10 rounded-lg bg-black bg-opacity-40 font-Nrj-fonts font-normal flex justify-center gap-2 items-center text-white">
        <i class="fa-regular fa-rocket"></i>
        <p>Fast</p>
      </div>

      <div
        class="w-24 h-10 rounded-lg bg-black bg-opacity-40 font-Nrj-fonts font-normal flex justify-center gap-2 items-center text-white">
        <i class="fa-regular fa-user-shield"></i>
        <p>Safe</p>
      </div>

      <div
        class="w-52 h-10 rounded-lg bg-black bg-opacity-40 font-Nrj-fonts flex font-normal justify-center gap-2 items-center text-white">
        <i class="fa-regular fa-house-circle-check"></i>
        <p>Seamless Booking</p>
      </div>
    </div>

    <!-- Buttons -->
    <div id="button-container" class="mt-4 gap-5 flex flex-row">
      <button onclick="window.location.href='nearby.php';"
        class="px-8 py-3 font-Nrj-fonts font-medium rounded-full text-white bg-for border border-for hover:border-white hover:font-semibold">
        Book Now
      </button>
      <button onclick="window.location.href='../info/contactus.html';"
        class="px-8 py-3 font-Nrj-fonts font-medium rounded-full bg-white border border-gray-300 hover:border-gray-800 hover:font-semibold">
        Contact Us
      </button>
    </div>

    <!-- Room Categories -->
    <div
      class="mt-10 w-[95%] h-60 md:h-72 lg:h-72 bg-white shadow-lg border-2 border-black border-opacity-20 rounded-md flex flex-col items-center">
      <h1 class="font-Nrj-fonts font-semibold text-black text-lg mt-[30px] text-center">
        Available Room Categories
      </h1>
      <!-- Steps Container -->
      <div class="flex w-full justify-evenly mt-8">
        <!-- House -->
        <div class="flex flex-col items-center justify-center">
          <div
            class="w-[60px] h-[60px] sm:h-[50px] sm:w-[50px]  md:h-[75px] md:w-[75px] lg:h-[75px] lg:w-[75px] rounded-full bg-gray-100 border-[0.5px] border-opacity-30 border-black flex justify-center items-center">
            <i class="fa-regular fa-house text-2xl md:text-3xl lg:text-3xl text-for"></i>

          </div>

          <p class="mt-2 font-Nrj-fonts font-semibold text-black">Houses</p>
          <p class="font-Nrj-fonts font-normal text-start p-1 text-sm hidden md:block lg:text-sm">
            Spacious and private, our houses offer comfort and
            <br />independence for a complete living experience.
          </p>

        </div>
        <!-- Apartment  -->
        <div class="flex flex-col items-center justify-center">
          <div
            class="w-[60px] h-[60px] sm:h-[50px] sm:w-[50px]  md:h-[75px] md:w-[75px] lg:h-[75px] lg:w-[75px] rounded-full bg-gray-100 border-[0.5px] border-opacity-30 border-black flex justify-center items-center">
            <i class="fa-regular fa-building text-2xl md:text-3xl lg:text-3xl text-for"></i>
          </div>

          <p class="mt-2 font-Nrj-fonts font-semibold text-black">
            Apartment
          </p>
          <p class="font-Nrj-fonts font-normal text-start p-1 text-sm hidden md:block lg:text-sm">
            Modern and stylish, our apartments are perfect for urban living
            <br />
            with a focus on functionality and unmatched convenience.
          </p>
        </div>
        <!-- Shared -->
        <div class="flex flex-col items-center justify-center">
          <div
            class="w-[60px] h-[60px] sm:h-[50px] sm:w-[50px]  md:h-[75px] md:w-[75px] lg:h-[75px] lg:w-[75px] rounded-full bg-gray-100 border-[0.5px] border-opacity-30 border-black flex justify-center items-center">
            <i class="fa-regular fa-users text-2xl md:text-3xl lg:text-3xl text-for"></i>
          </div>

          <p class="mt-2 font-Nrj-fonts font-semibold text-black">Shared</p>
          <p class="font-Nrj-fonts font-normal text-start p-1 text-sm hidden md:block lg:text-sm">
            Budget-friendly shared rooms designed for comfort and
            <br />
            meaningful connections with like-minded individuals.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Steps label of Room Booking -->
  <div class="text-center relative mt-12">
    <h1 class="font-Nrj-fonts font-semibold text-2xl md:text-4xl lg:text-4xl leading-tight">
      Quickly Book Your Room in <br />
      <span class="text-for text-xl md:text-3xl lg:text-3xl relative inline-block text-black">
        Just 4 Easy Steps 🚀
      </span>
    </h1>
  </div>

  <!-- Actual Steps of Room Booking -->
  <div class="flex flex-row items-center mt-24 justify-evenly ">
    <ol
      class="ml-12 relative text-gray-500 border-s-[3px] border-gray-200 dark:border-gray-700 dark:text-gray-400 font-Nrj-fonts text-lg">
      <li class="-mt-10 mb-[75px] ms-1 scroll-animation ">
        <span class="icon-container">
          <i class="fa-regular fa-home text-lg text-black"></i>
        </span>
        <h3 class="font-medium leading-tight text-for ml-8">Discover Property.</h3>
        <p class="text-sm font-Nrj-fonts mt-2 ml-8">
          StayEase helps users quickly find and explore <br />
          room rentals that fit your needs
        </p>
      </li>
      <li class="mb-[75px] ms-1 scroll-animation">
        <span class="icon-container">
          <i class="fa-regular fa-handshake text-lg text-black"></i>
        </span>
        <h3 class="font-medium leading-tight text-for ml-8">Negotiate Price.</h3>
        <p class="text-sm font-Nrj-fonts mt-2 ml-8">
          Tenants can directly discuss and agree on <br />
          rental rates with landlords
        </p>
      </li>
      <li class="mb-[75px] ms-1 scroll-animation">
        <span class="icon-container">
          <i class="fa-regular fa-money-check text-lg text-black"></i>
        </span>
        <h3 class="font-medium leading-tight text-for ml-8">Pay Security Deposit.</h3>
        <p class="text-sm font-Nrj-fonts mt-2 ml-8">
          Tenants securely submit their deposit online, <br />ensuring a
          smooth transaction for both parties.
        </p>
      </li>
      <li class="ms-1  scroll-animation">
        <span class="icon-container mt-1">
          <i class="fa-regular fa-thumbs-up text-lg text-black"></i>
        </span>
        <h3 class="font-medium leading-tight text-for ml-8">Booking Done!</h3>
        <p class="text-sm ml-8">Congrats your property is Booked Successfully!</p>
      </li>
    </ol>

    <div class="flex justify-center items-center scroll-animation">
      <!-- Circle -->
      <div class="w-32 h-32 md:w-72 md:h-72 lg:w-72 lg:h-72 bg-for bg-opacity-90 rounded-full relative">
        <!-- Image -->
        <img src="../assets/img/finger-pointing.png" alt="Finger Pointing"
          class="max-w-90 max-h-90 -mt-12 md:-mt-9 lg:-mt-[107px] " />
      </div>
    </div>
  </div>

  <!-- Testimonials -->
  <div class="mt-72 md:mt-12 lg:mt-12 w-full h-96 to-transparent flex justify-center items-center flex-col">
    <div class="">
      <h1 class="text-center font-Nrj-fonts font-medium text-xl md:text-3xl lg:text-3xl">
        Hear from our
        <span class="font-Nrj-fonts text-for">Happy</span> users ❤️
      </h1>
      <section class="pb-2 mt-12 mx-auto md:pb-1 max-w-7xl font-Nrj-fonts">
        <div class="gap-8 space-y-8 md:columns-2 lg:columns-3">
          <div class="p-8 bg-white border border-gray-300 drop-shadow-md aspect-auto rounded-xl shadow-gray-600/10">
            <div class="flex gap-4 items-start">
              <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/12.jpg" alt="user avatar"
                width="400" height="400" loading="lazy" />
              <div class="flex-1 flex justify-between items-start">
                <div>
                  <h6 class="text-lg font-medium text-gray-700">
                    Ravi Kumar
                  </h6>
                  <p class="text-sm text-gray-500">IT Professional - Delhi</p>
                </div>
              </div>
            </div>
            <p class="mt-8">
              "StayEase made my move easy! I found a budget-friendly room in a
              week."
            </p>
          </div>

          <div class="p-8 bg-white border border-gray-300 drop-shadow-md aspect-auto rounded-xl shadow-gray-600/10">
            <div class="flex gap-4 items-start">
              <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/5.jpg"
                alt="user avatar" width="200" height="200" loading="lazy" />
              <div class="flex-1 flex justify-between items-start">
                <div>
                  <h6 class="text-lg font-medium text-gray-700">
                    Anjali Sharma
                  </h6>
                  <p class="text-sm text-gray-500">
                    Young Professional - Goa
                  </p>
                </div>
              </div>
            </div>
            <p class="mt-8">
              "The interactive map helped me find a room near amenities.
              Smooth experience!"
            </p>
          </div>

          <div class="p-8 bg-white border border-gray-300 drop-shadow-md aspect-auto rounded-xl shadow-gray-600/10">
            <div class="flex gap-4 items-start">
              <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/18.jpg" alt="user avatar"
                width="200" height="200" loading="lazy" />
              <div class="flex-1 flex justify-between items-start">
                <div>
                  <h6 class="text-lg font-medium text-gray-700">
                    Vijay Singh
                  </h6>
                  <p class="text-sm text-gray-500">
                    Business Professional - Pune
                  </p>
                </div>
              </div>
            </div>
            <p class="mt-8">
              "StayEase is perfect for short-term rentals! Quick and easy to
              negotiate a great deal."
            </p>
          </div>
        </div>
      </section>
    </div>
  </div>

  <!-- Frequently Asked Questions Label -->
  <div class="flex flex-col items-center mt-64 md:mt-12 lg:mt-12 mb-1">
    <!-- Further reduced mt-10 to mt-6 and mb-2 to mb-1 -->
    <div class="flex flex-col md:flex-row items-center justify-between">
      <h1 class="font-Nrj-fonts font-semibold text-3xl mr-4">
        Questions ?
        <span class="font-Nrj-fonts font-medium text-2xl text-for italic">Look here.</span>
      </h1>
    </div>
  </div>

  <!-- Frequently Asked Questions Section -->
  <div id="faq" class="px-6 py-12 max-w-7xl mt-[-18px] md:mt-12  mx-auto lg:px-8 lg:mt-[-24px]">
    <div class="grid grid-cols-1 lg:grid-cols-2 mt-6 gap-8 items-start">
      <div class="group rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="cursor-pointer flex justify-between items-center" aria-controls="faq-1">
          <p class="font-semibold text-sm font-Nrj-fonts">What is StayEase?</p>
          <i class="fa-solid fa-caret-down  transition-transform"></i>
        </dt>
        <dd id="faq-1" class="hidden text-sm font-normal mt-6 font-Nrj-fonts">
          <p>StayEase is a platform for finding and renting affordable shared accommodations in new cities.</p>
        </dd>
      </div>
      <div class="group cursor-pointer rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="flex justify-between items-center" aria-controls="faq-2">
          <p class="font-semibold text-sm font-Nrj-fonts">How do I search for a room?</p>
          <i class="fa-solid fa-caret-down  transition-transform"></i>
        </dt>
        <dd id="faq-2" class="hidden text-sm font-Nrj-fonts font-normal mt-6">
          <p>You can use our interactive map or search bar to filter rooms by location, price, and amenities.</p>
        </dd>
      </div>
      <div class="group cursor-pointer rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="flex justify-between items-center" aria-controls="faq-3">
          <p class="font-semibold text-sm font-Nrj-fonts">Is there a booking fee?</p>
          <i class="fa-solid fa-caret-down  transition-transform"></i>
        </dt>
        <dd id="faq-3" class="hidden text-sm font-Nrj-fonts font-normal mt-6">
          <p>Yes, a small booking fee may apply when reserving a room, which will be displayed before you confirm your
            booking.</p>
        </dd>
      </div>
      <div class="group rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="cursor-pointer flex justify-between items-center" aria-controls="faq-4">
          <p class="font-semibold text-sm font-Nrj-fonts">Can I communicate with landlords?</p>
          </p>
          <i class="fa-solid fa-caret-down  transition-transform"></i>
        </dt>
        <dd id="faq-4" class="hidden text-sm font-normal mt-6 font-Nrj-fonts">
          <p>Yes, StayEase allows secure messaging between tenants and landlords for all inquiries.</p>
        </dd>
      </div>
      <div class="group cursor-pointer rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="flex justify-between items-center" aria-controls="faq-5">
          <p class="font-semibold text-sm font-Nrj-fonts">How do I pay my rent?</p>
          <i class="fa-solid fa-caret-down transition-transform"></i>
        </dt>
        <dd id="faq-5" class="hidden text-sm font-Nrj-fonts font-normal mt-6">
          <p>Payments are securely processed through Stripe, allowing for various payment methods, including credit and
            debit cards.</p>
        </dd>
      </div>
      <div class="group cursor-pointer rounded-xl border border-gray-200 bg-gray-50 p-6">
        <dt class="flex justify-between items-center" aria-controls="faq-6">
          <p class="font-semibold text-sm font-Nrj-fonts">What amenities are available?</p>
          <i class="fa-solid fa-caret-down  transition-transform"></i>
        </dt>
        <dd id="faq-6" class="hidden text-sm font-Nrj-fonts font-normal mt-6">
          <p>Amenities vary by listing, but many include Wi-Fi, laundry facilities, and kitchen access. Check individual
            listings for details.</p>
        </dd>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-black font-Nrj-fonts ">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
      <div class="md:flex md:justify-between">
        <div class="mb-6 md:mb-0 ml-14 md:ml-0 lg:ml-0">
          <a href="#" id="brands" class="font-Nrj-fonts font-semibold text-md flex items-center ml-2">
            <img class="max-w-10 max-h-44 ml-5" src="../assets/img/stayease logo.svg" alt="" />
            <p class="font-Nrj-fonts ml-2 text-xl text-white">StayEase</p>
          </a>
        </div>
        <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
          <div>
            <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">Resources</h2>
            <ul class="text-white dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="#" class="hover:underline">StayEase</a>
              </li>
              <li>
                <a href="../info/blog.html" class="hover:underline">Blog</a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">Follow us</h2>
            <ul class="text-white dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="https://github.com/Niraj-Paswan" class="hover:underline ">Github</a>
              </li>
              <li>
                <a href="https://discord.gg" class="hover:underline">Discord</a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">Legal</h2>
            <ul class="text-white dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="../info/privacy.html" class="hover:underline">Privacy Policy</a>
              </li>
              <li>
                <a href="../info/tc.html" class="hover:underline">Terms &amp; Conditions</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
        <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2025 <a href="#"
            class="hover:underline">StayEase™</a>. All Rights Reserved.
        </span>
        <div class="flex mt-4 sm:justify-center sm:mt-0">
          <a href="#" class="text-white hover:text-for dark:hover:text-white">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 8 19">
              <path fill-rule="evenodd"
                d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Facebook page</span>
          </a>
          <a href="#" class="text-white hover:text-for dark:hover:text-white ms-5">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 17">
              <path fill-rule="evenodd"
                d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Twitter page</span>
          </a>
          <a href="https://github.com/Niraj-Paswan/stay" class="text-white hover:text-for dark:hover:text-white ms-5">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                clip-rule="evenodd" />
            </svg>
            <span class="sr-only">GitHub account</span>
          </a>
        </div>
      </div>
    </div>
  </footer>
  <script>
    // Select all elements with the 'scroll-animation' class
    const animatedElements = document.querySelectorAll('.scroll-animation');

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible'); // Add 'visible' class when in viewport
          } else {
            entry.target.classList.remove('visible'); // Remove 'visible' class when out of viewport
          }
        });
      },
      { threshold: 0.1 } // Trigger when 10% of the element is visible
    );

    // Observe each scroll animation element
    animatedElements.forEach((element) => observer.observe(element));

    function toggleDropdown(menuId) {
      const dropdown = document.getElementById(menuId);

      // Toggle visibility classes
      dropdown.classList.toggle("hidden");
      dropdown.classList.toggle("opacity-0");
      dropdown.classList.toggle("scale-95");
    }

    document.addEventListener("DOMContentLoaded", () => {
      const userMenuButton = document.getElementById("user-menu-button");
      const dropdownMenu = document.getElementById("dropdown-menu");

      userMenuButton.addEventListener("click", (event) => {
        event.stopPropagation();
        const isHidden = dropdownMenu.classList.contains("hidden");
        if (isHidden) {
          dropdownMenu.classList.remove("hidden", "opacity-0", "scale-95");
          dropdownMenu.classList.add("opacity-100", "scale-100");
        } else {
          dropdownMenu.classList.add("opacity-0", "scale-95");
          setTimeout(() => {
            dropdownMenu.classList.add("hidden");
            dropdownMenu.classList.remove("opacity-100", "scale-100");
          }, 200);
        }
      });

      document.addEventListener("click", (event) => {
        if (
          !userMenuButton.contains(event.target) &&
          !dropdownMenu.contains(event.target)
        ) {
          dropdownMenu.classList.add("opacity-0", "scale-95");
          setTimeout(() => {
            dropdownMenu.classList.add("hidden");
            dropdownMenu.classList.remove("opacity-100", "scale-100");
          }, 200);
        }
      });
    });

    // Mobile Menu Handler
    const handleMenu = () => {
      const menu = document.getElementById("mobile_men");
      menu.classList.toggle("hidden");
    };

    const dtElements = document.querySelectorAll('dt');
    dtElements.forEach(element => {
      element.addEventListener('click', () => {
        const ddId = element.getAttribute('aria-controls');
        const ddElement = document.getElementById(ddId);
        const ddArrowIcon = element.querySelector('i'); // Select the icon directly

        // Toggle visibility of the answer and rotation of the icon
        ddElement.classList.toggle('hidden');
        ddArrowIcon.classList.toggle('-rotate-180');
      });
    });
  </script>
</body>

</html>