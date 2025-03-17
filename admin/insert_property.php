<?php
include '../Database/dbconfig.php';

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle file uploads
function handleUpload($fileInputName)
{
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
        // Set the directory where you want to save the images
        $uploadDir = "../public/uploads/";
        // Ensure the upload directory exists and is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Create a unique filename to prevent overwrites
        $fileName = basename($_FILES[$fileInputName]['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFile)) {
            return $targetFile;
        }
    }
    // Return an empty string if upload failed or file was not provided
    return "";
}

// Retrieve form data
$property_name = $_POST['property_name'];
$property_location = $_POST['property_location'];
$property_price = $_POST['property_price'];
$property_description = $_POST['property_description'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$property_type = $_POST['property_type'];
$bedrooms = $_POST['bedrooms'];
$bathrooms = $_POST['bathrooms'];
$area = $_POST['area'];

// Handle the "Allow Sharing" checkbox
$is_sharable = isset($_POST['is_sharable']) ? 1 : 0;

// Ensure sharing is only allowed for 2-bedroom properties
if ($bedrooms != 2) {
    $is_sharable = 0;
}

// Process file uploads
$main_img = handleUpload('main_img');
$kitchen_img = handleUpload('kitchen_img');
$washroom_img = handleUpload('washroom_img');
$gallery_img = handleUpload('gallery_img');

// Prepare the SQL statement
$sql = "INSERT INTO properties (
            property_name, 
            property_location, 
            property_price, 
            property_description, 
            latitude, 
            longitude, 
            main_image, 
            kitchen_img, 
            washroom_img, 
            gallery_img, 
            property_type, 
            bedrooms, 
            bathrooms, 
            area, 
            is_sharable
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters to the SQL query
$stmt->bind_param(
    "ssssddsssssiiii",
    $property_name,
    $property_location,
    $property_price,
    $property_description,
    $latitude,
    $longitude,
    $main_img,
    $kitchen_img,
    $washroom_img,
    $gallery_img,
    $property_type,
    $bedrooms,
    $bathrooms,
    $area,
    $is_sharable
);

// Execute the statement and check for errors
if ($stmt->execute()) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Property Added</title>
        <!-- Include Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Google Fonts: Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            /* Apply Poppins font */
            body {
                font-family: "Poppins", sans-serif;
            }
            /* Custom animation for the popup */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fadeInUp {
                animation: fadeInUp 0.5s ease-out;
            }
        </style>
    </head>
    <body class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-5 rounded-md shadow-md animate-fadeInUp">
            <div class="flex items-center">
                <span class="text-green-700">
                    <i class="fa-solid fa-check-circle fa-3x"></i>
                </span>
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold">Success!</h2>
                    <p class="text-lg">Property added successfully.</p>
                </div>
            </div>
        </div>
        <script>
            // After 2.5 seconds, redirect to the dashboard page.
            setTimeout(function() {
                window.location.href = "main.php";
            }, 2500);
        </script>
    </body>
    </html>
    ';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>