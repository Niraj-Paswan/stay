<?php
// Database connection settings -- update these with your credentials
$servername = "localhost:3307"; // Database host
$username   = "root";           // Database username
$password   = "";               // Database password
$dbname     = "stayease";          // Database name

// Create a new MySQLi connection using the correct variable names
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle file uploads
function handleUpload($fileInputName) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
        // Set the directory where you want to save the images
        $uploadDir = "uploads/";
        // Ensure the upload directory exists and is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Create a unique filename to prevent overwrites
        $fileName   = basename($_FILES[$fileInputName]['name']);
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
$property_name        = $_POST['property_name'];
$property_location    = $_POST['property_location'];
$property_price       = $_POST['property_price'];
$property_description = $_POST['property_description'];
$latitude             = $_POST['latitude'];
$longitude            = $_POST['longitude'];
$property_type        = $_POST['property_type'];
$bedrooms             = $_POST['bedrooms'];
$bathrooms            = $_POST['bathrooms'];
$area                 = $_POST['area'];

// Process file uploads
$main_img     = handleUpload('main_img');
$kitchen_img  = handleUpload('kitchen_img');
$washroom_img = handleUpload('washroom_img');
$gallery_img  = handleUpload('gallery_img');

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
            area
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters to the SQL query
// "ssssddsssssiii" indicates the types:
// s - string, d - double, i - integer
$stmt->bind_param(
    "ssssddsssssiii", 
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
    $area
);

// Execute the statement and check for errors
if ($stmt->execute()) {
    echo "Property added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
