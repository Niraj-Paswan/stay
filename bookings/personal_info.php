<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    // Fetch the logged-in user's email
    $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : "Email not found.";
} else {
    echo "User not logged in.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <title>StayEase | Personal Information</title>
    <script>
      function handleFileSelect(event) {
        event.preventDefault();
        const fileInput = document.getElementById("idProof");
        const file = event.target.files[0] || event.dataTransfer.files[0];

        if (file) {
          fileInput.files = event.target.files || event.dataTransfer.files;
          displayFileName(file);
        }
      }

      function displayFileName(file) {
        const fileInfo = document.getElementById("file-info");
        fileInfo.textContent = file.name;

        const trashIcon = document.getElementById("trash-icon");
        trashIcon.style.display = "inline-block";
      }

      function handleDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        event.target.style.borderColor = "green";
      }

      function handleDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        event.target.style.borderColor = "#ccc";
      }

      function triggerFileInput() {
        document.getElementById("idProof").click();
      }

      function cancelFileSelection() {
        const fileInput = document.getElementById("idProof");
        fileInput.value = "";
        const fileInfo = document.getElementById("file-info");
        fileInfo.textContent = "";
        const trashIcon = document.getElementById("trash-icon");
        trashIcon.style.display = "none";
      }

      function validateForm(event) {
        event.preventDefault();
        let valid = true;

        // Clear previous error messages
        document.querySelectorAll(".error-message").forEach((msg) => {
          msg.textContent = "";
        });

        // Form field values
        const formElements = {
          name: document.getElementById("name").value,
          phone: document.getElementById("phone").value,
          email: document.getElementById("email").value,
          file: document.getElementById("idProof").files[0],
          rentDate: document.getElementById("rentDate").value,
        };

        // Validation patterns
        const validations = {
          name: /^[a-zA-Z\s]{3,}$/, // At least 3 characters, only letters and spaces
          phone: /^[789]\d{9}$/, // Phone number starts with 7, 8, or 9 followed by 9 digits
          email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, // Basic email validation
          image: /\.(png|jpe?g)$/i, // PNG or JPEG image file
        };

        // Validate name
        if (!validations.name.test(formElements.name)) {
          document.getElementById("name-error").textContent =
            "Name should be at least 3 characters long and contain only letters and spaces.";
          valid = false;
        }

        // Validate phone number (starts with 7, 8, or 9 followed by 9 digits)
        if (!validations.phone.test(formElements.phone)) {
          document.getElementById("phone-error").textContent =
            "Phone number should be 10 digits and start with 7, 8, or 9.";
          valid = false;
        }

        // Validate email
        if (!validations.email.test(formElements.email)) {
          document.getElementById("email-error").textContent =
            "Please enter a valid email address.";
          valid = false;
        }

        // Validate rent start date (must be in the future)
        if (formElements.rentDate < new Date().toISOString().split("T")[0]) {
          document.getElementById("rentDate-error").textContent =
            "Rent start date must be a future date.";
          valid = false;
        }

        // Validate file upload
        if (
          !formElements.file ||
          !validations.image.test(formElements.file.name)
        ) {
          document.getElementById("file-error").textContent =
            "Please upload an image file in PNG or JPEG format.";
          valid = false;
        }

        // If all inputs are valid, submit the form and redirect
        if (valid) {
          alert("Form submitted successfully!");

          // Redirect to the next page
          window.location.href = "negotiate.html"; // Redirect to the new page after success
        }
      }

      document.addEventListener("DOMContentLoaded", function () {
        const rentDateInput = document.getElementById("rentDate");
        const today = new Date();
        const maxDate = new Date();
        maxDate.setDate(today.getDate() + 15);

        rentDateInput.min = today.toISOString().split("T")[0];
        rentDateInput.max = maxDate.toISOString().split("T")[0];
      });
    </script>
    <style>
      body {
        background-image: url("../assets/img/beams-home@95.jpg");
        background-size: cover;
        background-position: center;
      }
    </style>
  </head>

  <body
    class="bg-gray-100 flex items-center justify-center min-h-screen p-8 font-Nrj-fonts"
  >
    <div
      class="bg-white p-8 rounded-lg shadow-lg w-[550px] border-[0.5px] border-gray-300"
    >
      <div class="flex justify-center items-center space-x-1 mb-4">
        <h2 class="text-xl font-semibold text-start text-gray-800">
          Enter Your Personal Information
        </h2>
      </div>

      <form
        action="../bookings/negotiate.html"
        onsubmit="validateForm(event)"
        method="POST"
        enctype="multipart/form-data"
      >
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700"
            >Full Name</label
          >
          <input
            type="text"
            id="name"
            name="name"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-black focus:outline-none"
            placeholder="Arun Verma"
          />
          <p id="name-error" class="text-red-500 text-xs error-message"></p>
        </div>

        <div class="mb-4">
          <label for="phone" class="block text-sm font-medium text-gray-700"
            >Phone Number</label
          >
          <input
            type="text"
            id="phone"
            name="phone"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-black focus:outline-none"
            placeholder="9856124732"
          />
          <p id="phone-error" class="text-red-500 text-xs error-message"></p>
        </div>

        <div class="mb-4">
          <label for="rentDate" class="block text-sm font-medium text-gray-700"
            >Rent Start Date</label
          >
          <input
            type="date"
            id="rentDate"
            name="rentDate"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-black focus:outline-none text-gray-400"
            min=""
            max=""
          />
          <p id="rentDate-error" class="text-red-500 text-xs error-message"></p>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Gender</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="gender"
                value="male"
                class="form-radio"
              />
              <span class="ml-2">Male</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="gender"
                value="female"
                class="form-radio"
              />
              <span class="ml-2">Female</span>
            </label>
          </div>
        </div>

        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Email Address</label
          >
          <input type="email" id="email" name="email" 
    value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" 
    class="mt-1 block w-full px-3 py-2 border-[1.5px] border-gray-400 rounded-md shadow-sm bg-gray-100 
           focus:outline-none focus:ring-[1.5px] focus:ring-gray-700 cursor-not-allowed" 
    readonly />

          <p id="email-error" class="text-red-500 text-xs error-message"></p>
        </div>

        <div class="mb-4">
          <label for="idProof" class="block text-sm font-medium text-gray-700"
            >Upload ID Proof</label
          >
          <div
            id="drop-area"
            class="border-2 border-dashed border-gray-300 p-5 text-center cursor-pointer bg-gray-50 hover:bg-gray-100 rounded-md mt-2 group text-gray-500 hover:text-black hover:border-gray-400"
            ondrop="handleFileSelect(event)"
            ondragover="handleDragOver(event)"
            ondragleave="handleDragLeave(event)"
            onclick="triggerFileInput()"
          >
            <i
              class="fa-regular fa-arrow-up-from-bracket mr-2 text-gray-500 group-hover:text-black"
            ></i>
            Click to Select File
          </div>
          <input
            type="file"
            id="idProof"
            name="idProof"
            accept=".png, .jpeg, .jpg"
            class="hidden"
            onchange="handleFileSelect(event)"
          />
          <div class="flex flex-row justify-between items-center mt-2">
            <div id="file-info" class="mt-2 text-sm text-gray-600"></div>
            <i
              id="trash-icon"
              class="fa-solid fa-trash hidden text-red-400 text-sm cursor-pointer relative hover:text-red-600"
              onclick="cancelFileSelection()"
            ></i>
          </div>
          <p id="file-error" class="text-red-500 text-xs error-message"></p>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Submit
        </button>
      </form>
    </div>
  </body>
</html>
