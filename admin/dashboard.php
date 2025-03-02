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
  <title>Sta</title>
  <!-- Link to Tailwind CSS -->
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <!-- Google Fonts for Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body class="font-Poppins">
  <div class="p-4 min-h-screen bg-gray-100" id="main-content">
    <!-- Dashboard Section -->
    <div id="dashboard" class="w-full h-[550px] bg-white p-8 rounded-md shadow-sm border border-gray-300">
      <div class="flex flex-row justify-start items-start">
        <h3 class="text-lg text-gray-600 font-normal mb-2">
          Total Listings :
        </h3>
        <p class="text-2xl font-semibold text-gray-800 mb-2 ml-2">
          <?php echo count($properties); ?> Properties
        </p>
      </div>

      <div class="flex flex-row justify-center items-center gap-4 p-1 overflow-hidden">
        <?php foreach ($properties as $property): ?>
          <!-- Property Cards 1-->
          <div id="property-card"
            class="flex justify-evenly items-center flex-col gap-8 md:flex-row lg:flex-row mt-6 font-Nrj-fonts">
            <div class="w-64 bg-white border border-gray-300 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
              <!-- Image -->
              <div class="relative">
                <img id="property-image" class="rounded-t-lg h-40 w-full object-cover"
                  src="../public/<?php echo $property['main_image']; ?>" alt="Property Image" />
                <!-- Verified Badge -->
                <div
                  class="absolute top-2 right-2 bg-white text-sm font-medium px-2 py-1 text-black flex items-center rounded-sm shadow">
                  <i class="fa-solid fa-badge-check mr-1 text-blue-600"></i>
                  Verified
                </div>
              </div>

              <!-- Content Section -->
              <div class="px-4 py-2">
                <!-- Type Badge -->
                <div id="property-type-container"
                  class="flex flex-row justify-center items-center w-24 h-6 bg-gray-50 rounded-sm border-[1.5px] border-gray-300">
                  <p id="property-type" class="font-Nrj-fonts font-normal text-sm text-gray-800">
                    <?php echo $property['property_type']; ?>
                  </p>
                </div>
                <!-- Property Name -->
                <h5 id="property-name"
                  class="mt-1 text-[16px] font-semibold tracking-tight text-gray-900 dark:text-white">
                  <?php echo $property['property_name']; ?>
                </h5>
                <!-- Location -->
                <p id="property-location" class="text-sm font-normal text-gray-600 dark:text-gray-400 flex items-center">
                  <?php echo $property['property_location']; ?>
                </p>
                <!-- Rent and View Link -->
                <div id="property-details" class="flex flex-row items-center justify-between mt-2">
                  <p id="property-rent" class="text-lg font-semibold font-Nrj-fonts text-black">
                    <span class="text-sm font-normal">from</span> ₹<?php echo $property['property_price'] ?>/
                    <span class="text-sm font-normal">month</span>
                  </p>
                </div>

                <!-- Edit & Delete Buttons -->
                <div class="flex justify-evenly py-2 mt-2 gap-4">
                  <!-- Edit Button -->
                  <a href="edit_property.php?id=<?php echo $property['id']; ?>"
                    class="w-full h-9 flex justify-center items-center gap-1 bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fa-solid fa-pen mr-1"></i> Edit
                  </a>

                  <!-- Delete Button with confirmation -->
                  <button onclick="confirmDelete(<?php echo $property['id']; ?>)"
                    class="w-full flex justify-center items-center gap-1 bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition duration-200">
                    <i class="fa-solid fa-trash mr-1"></i> Delete
                  </button>

                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
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