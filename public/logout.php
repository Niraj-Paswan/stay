<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logged Out | StayEase</title>
    <link
      rel="shortcut icon"
      href="../assets/img/stayease logo.svg"
      type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <style>
      body {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
          url("../assets/img/beams-home@95.jpg");
        background-size: cover;
        background-position: center;
        font-family: "Poppins", sans-serif;
      }
      .logout-icon {
        animation: bounce 1s infinite alternate;
      }
      @keyframes bounce {
        from {
          transform: translateY(0px);
        }
        to {
          transform: translateY(-5px);
        }
      }
    </style>
  </head>

  <body class="flex items-center justify-center min-h-screen text-gray-100">
    <div
      class="bg-white/90 backdrop-blur-sm p-8 rounded-lg text-center max-w-md w-full border-[1.5px] border-gray-300 shadow-xl"
    >
      <!-- Icon with Animation -->
      <i
        class="fa-solid fa-arrow-right-from-bracket text-4xl text-black logout-icon"
      ></i>

      <!-- Message -->
      <h2 class="text-2xl font-semibold mt-4 text-gray-900">
        You’ve Been Logged Out
      </h2>
      <p class="text-gray-600 mt-2 text-sm">
        Thank you for using StayEase. We hope to see you again soon!
      </p>

      <!-- Action Button -->
      <a
        href="login.php"
        class="mt-6 inline-block w-full px-4 py-3 font-semibold text-white bg-blue-500 hover:bg-for transition duration-300 rounded-md"
      >
      Log in again
      </a>
    </div>
  </body>
</html>
