<?php
// Database connection
$host = "localhost:3307";
$username = "root";
$password = "";
$database = "stayease";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, property_name, property_location, property_price, latitude, longitude, main_image, property_type, bathrooms, bedrooms, area FROM properties";
$result = $conn->query($sql);

$properties = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $properties[] = $row;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StayEase - Properties</title>
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body class=" font-Nrj-fonts bg-gray-100 p-6">
  <div class="container mx-auto">

    <h3 class="text-lg text-gray-600 font-normal">Total Listings: <span class="text-2xl font-semibold text-gray-800">
        <?php echo count($properties); ?> Properties</span></h3>

    <div class="grid grid-cols-4 gap-6 mt-6">
      <?php foreach ($properties as $property): ?>
        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
          <div class="relative">
            <img src="../public/<?php echo $property['main_image']; ?>" alt="Property Image"
              class="w-full h-40 object-cover">
            <div class="absolute top-2 right-2 bg-white text-sm px-2 py-1 text-black flex items-center rounded-sm shadow">
              <i class="fa-solid fa-badge-check text-blue-600 mr-1"></i> Verified
            </div>
          </div>
          <div class="p-4">
            <div class="text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-sm px-2 py-1 w-fit">
              <?php echo $property['property_type']; ?>
            </div>
            <h5 class="mt-2 text-lg font-semibold text-gray-900"> <?php echo $property['property_name']; ?> </h5>
            <p class="text-sm text-gray-600"> <?php echo $property['property_location']; ?> </p>
            <p class="mt-2 text-lg font-semibold text-black"> ₹<?php echo $property['property_price']; ?>/month </p>
            <div class="flex justify-between items-center mt-4">
              <a href="edit_property.php?id=<?php echo $property['id']; ?>"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"> <i class="fa-solid fa-pen"></i>
                Edit </a>
              <button onclick="confirmDelete(<?php echo $property['id']; ?>)"
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"> <i class="fa-solid fa-trash"></i>
                Delete </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this property?")) {
        window.location.href = "delete_property.php?id=" + id;
      }
    }
  </script>
</body>

</html>