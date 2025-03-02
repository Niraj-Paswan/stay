<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StyaEase | Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    html,
    body {
      height: 100%;
    }

    /* Custom styles for the active sidebar item */
    .active-link {
      background-color: #1d4ed8;
      color: white !important;
    }

    /* Floating Button Styles */
    .floating-button {
      position: fixed;
      bottom: 20px;
      right: 40px;
      background-color: white;
      border: 2px solid gray;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .floating-button:hover {
      background-color: #f3f3f3;
    }

    .floating-button::after {
      content: "Add New Listing";
      position: absolute;
      bottom: 60px;
      right: 50%;
      transform: translateX(50%);
      background-color: black;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }

    .floating-button:hover::after {
      opacity: 1;
    }
  </style>
</head>

<body class="bg-gray-100 font-Nrj-fonts h-full">
  <div class="flex h-screen">
    <!-- Navbar -->
    <header class="bg-white shadow-sm z-10 fixed w-full border-b-2 border-gray-200">
      <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center space-x-4">
          <img class="w-8 h-8" src="../assets/img/stayease logo.svg" alt="StayEase Logo" />
          <h1 class="text-lg font-semibold text-black md:text-2xl lg:text-2xl">
            StayEase
          </h1>
        </div>
        <div class="flex items-center space-x-4">
          <p class="text-black">Hii 👋 Admin</p>
          <div class="relative">
            <i id="profileIcon" class="fa-solid fa-circle-user text-for text-3xl cursor-pointer"></i>
            <div id="dropdownMenu"
              class="hidden absolute right-0 mt-2 w-40 bg-white shadow-md rounded-md border border-gray-200">
              <button
                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600"
                onclick="showSignOutConfirmation()">
                <i class="fa-solid fa-right-from-bracket text-red-500 mr-2"></i>
                Sign Out
              </button>
            </div>
            <div id="signOutModal"
              class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
              <div class="bg-white p-6 rounded-md shadow-lg w-96">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">
                  Are you sure you want to log out?
                </h2>
                <div class="flex justify-end space-x-4">
                  <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400"
                    onclick="closeModal()">
                    No
                  </button>
                  <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="signOut()">
                    Yes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Sidebar -->
    <aside class="bg-white w-64 shadow-md border border-gray-300 z-0 pt-16 pl-4 pr-4">
      <nav class="mt-4 mr-4">
        <a href="#" class="flex items-center px-4 py-4 rounded-md text-gray-600 hover:text-black"
          onclick="showContent('dashboard', this)">
          <i class="fas fa-home mr-3"></i> Listings
        </a>
        <a href="#" class="flex items-center px-4 py-4 rounded-md text-gray-600 hover:text-black"
          onclick="showContent('bookinggs', this)">
          <i class="fas fa-calendar-check mr-3"></i> Bookings
        </a>
        <a href="#" class="flex items-center px-4 py-4 rounded-md text-gray-600 hover:text-black"
          onclick="showContent('user', this)">
          <i class="fas fa-users mr-3"></i> Users
        </a>
        <a href="#" class="flex items-center px-4 py-4 rounded-md text-gray-600 hover:text-black"
          onclick="showContent('payments', this)">
          <i class="fas fa-credit-card mr-3"></i> Payments
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 pt-16 overflow-y-auto h-screen">
      <div class="h-full w-full" id="main-content">
        <iframe class="w-full h-full" src="../admin/main_dashboard.php" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div class="floating-button" onclick="location.href='property_upload.html'">
    <i class="fa-solid fa-house-circle-check text-black text-xl"></i>
  </div>

  <script>
    // Function to show content based on sidebar item clicked and update the active state
    function showContent(contentId, clickedItem) {
      // Remove the active state from all sidebar links
      const sidebarLinks = document.querySelectorAll("aside nav a");
      sidebarLinks.forEach((link) => {
        link.classList.remove("active-link");
      });
      // Add the active state to the clicked item
      clickedItem.classList.add("active-link");

      // Fetch and load the corresponding HTML content
      fetch(contentId + ".php")
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("main-content").innerHTML = data;
        })
        .catch((error) => {
          console.error("Error loading content:", error);
        });
    }

    // Profile Dropdown Toggle
    const profileIcon = document.getElementById("profileIcon");
    const dropdownMenu = document.getElementById("dropdownMenu");

    profileIcon.addEventListener("click", () => {
      dropdownMenu.classList.toggle("hidden");
    });

    // Close dropdown on outside click
    document.addEventListener("click", (e) => {
      if (
        !profileIcon.contains(e.target) &&
        !dropdownMenu.contains(e.target)
      ) {
        dropdownMenu.classList.add("hidden");
      }
    });

    // Function to show the sign-out confirmation modal
    function showSignOutConfirmation() {
      document.getElementById("signOutModal").classList.remove("hidden");
    }

    // Function to close the modal without signing out
    function closeModal() {
      document.getElementById("signOutModal").classList.add("hidden");
    }

    // Function to handle the sign-out action
    function signOut() {
      // Logic for signing out the user
      alert("You have been signed out.");
      window.location.href = "../public/adminlogin.php";
      closeModal();
    }
  </script>
</body>

</html>