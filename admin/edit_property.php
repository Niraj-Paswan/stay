<?php
// Database connection
include '../Database/dbconfig.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $id = $_POST['id'];
    $property_name = $_POST['property_name'];
    $property_location = $_POST['property_location'];
    $property_price = $_POST['property_price'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $property_type = $_POST['property_type'];
    $bathrooms = $_POST['bathrooms'];
    $bedrooms = $_POST['bedrooms'];
    $area = $_POST['area'];

    // Fetch existing images
    $sql = "SELECT main_image, kitchen_img, washroom_img, gallery_img FROM properties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $existing_images = $stmt->get_result()->fetch_assoc();

    // Image upload handling
    $image_columns = ['main_image', 'kitchen_img', 'washroom_img', 'gallery_img'];
    $upload_dir = "../public/";
    $new_images = [];

    foreach ($image_columns as $column) {
        if (!empty($_FILES[$column]['name'])) {
            $image_name = time() . "_" . basename($_FILES[$column]['name']);
            $target_file = $upload_dir . $image_name;

            if (move_uploaded_file($_FILES[$column]['tmp_name'], $target_file)) {
                // Delete old image if exists
                if (!empty($existing_images[$column]) && file_exists($upload_dir . $existing_images[$column])) {
                    unlink($upload_dir . $existing_images[$column]);
                }
                $new_images[$column] = $image_name;
            }
        } else {
            $new_images[$column] = $existing_images[$column]; // Keep old image if no new one uploaded
        }
    }

    // Update query with images
    $sql = "UPDATE properties SET 
                property_name=?, property_location=?, property_price=?, 
                latitude=?, longitude=?, property_type=?, 
                bathrooms=?, bedrooms=?, area=?, 
                main_image=?, kitchen_img=?, washroom_img=?, gallery_img=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssisssiiissssi",
        $property_name,
        $property_location,
        $property_price,
        $latitude,
        $longitude,
        $property_type,
        $bathrooms,
        $bedrooms,
        $area,
        $new_images['main_image'],
        $new_images['kitchen_img'],
        $new_images['washroom_img'],
        $new_images['gallery_img'],
        $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Property updated successfully!'); window.location.href='dashboard.php';</script>";
        exit;
    } else {
        echo "Error updating property: " . $conn->error;
    }
}

// Fetch property details if ID is provided in URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid property ID.");
}

$sql = "SELECT * FROM properties WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    die("Property not found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <!-- Link to Tailwind CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
    <!-- Google Fonts for Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            background-image: url("../assets/img/beams-home@95.jpg");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen font-Nrj-fonts p-12">

    <div class="bg-white p-6 rounded-md shadow-md w-[60%]  border-[1.5px] border-gray-300">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Edit Property</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $property['id']; ?>">

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property Name</label>
                    <input type="text" name="property_name" value="<?php echo $property['property_name']; ?>" required
                        class="w-full border border-gray-300 p-2 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" name="property_location" value="<?php echo $property['property_location']; ?>"
                        required class="w-full border border-gray-300 p-2 rounded-md">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                    <input type="number" name="property_price" value="<?php echo $property['property_price']; ?>"
                        required class="w-full border border-gray-300 p-2 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                    <input type="text" name="property_type" value="<?php echo $property['property_type']; ?>" required
                        class="w-full border border-gray-300 p-2 rounded-md">
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="grid grid-cols-2 gap-6">
                <?php
                $images = [
                    'main_image' => 'Main Image',
                    'kitchen_img' => 'Kitchen Image',
                    'washroom_img' => 'Washroom Image',
                    'gallery_img' => 'Gallery Image'
                ];

                foreach ($images as $column => $label) {
                    echo '<div class="flex flex-col items-center">';
                    echo '<label class="block text-sm font-medium text-gray-700 mb-2 text-center">' . $label . '</label>';
                    echo '<div class="w-40 h-32 overflow-hidden border border-gray-300 rounded-md flex items-center justify-center bg-gray-100">';
                    echo '<img src="../public/' . $property[$column] . '" class="max-w-full h-full object-contain">';
                    echo '</div>';
                    echo '<input type="file" name="' . $column . '" class="mt-2 border border-gray-300 p-2 rounded-md text-sm w-full">';
                    echo '</div>';
                }
                ?>
            </div>



            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bathrooms</label>
                    <input type="number" name="bathrooms" value="<?php echo $property['bathrooms']; ?>" required
                        class="w-full border border-gray-300 p-2 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Bedrooms</label>
                    <input type="number" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required
                        class="w-full border border-gray-300 p-2 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Area (sqft)</label>
                    <input type="number" name="area" value="<?php echo $property['area']; ?>" required
                        class="w-full border border-gray-300 p-2 rounded-md">
                </div>
            </div>

            <div class="flex justify-center items-center gap-12 mt-8">
                <a href="dashboard.php"
                    class="px- py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-center w-full">
                    Cancel
                </a>
                <button type="submit"
                    class="px-24 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center w-full">
                    Update Property
                </button>
            </div>

        </form>
    </div>

</body>

</html>