<?php
include '../Database/dbconfig.php';

$sql = "SELECT id, property_name, property_location, property_price, latitude, longitude, main_image,kitchen_img,gallery_img,washroom_img, property_type, bathrooms, bedrooms, area, is_sharable FROM properties";
$result = $conn->query($sql);
$properties = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $properties[] = [
      "pid" => $row["id"],
      "property_name" => $row["property_name"],
      "location" =>
        $row["property_location"],
      "coordinates" => [
        (float) $row["longitude"],
        (float) 
        $row["latitude"]
      ],
      "price" => $row["property_price"],
      "image" =>
        $row["main_image"],
      "washroom" => $row["washroom_img"],
      "gallery" =>
        $row["gallery_img"],
      "kitchen" => $row["kitchen_img"],
      "type" =>
        $row["property_type"],
      "bathrooms" => $row["bathrooms"] ?? "N/A",
      "bedrooms" =>
        $row["bedrooms"] ?? "N/A",
      "area" => $row["area"] ?? "N/A",
      "is_sharable" =>
        isset($row["is_sharable"]) ? $row["is_sharable"] : 0
    ];
  }
}
$conn->close(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Property Carousel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .carousel-container {
      overflow: hidden;
      position: relative;
    }

    .carousel-track {
      display: flex;
      gap: 1.5rem;
      transition: transform 0.3s ease-in-out;
    }

    .gradient-shadow {
      position: absolute;
      top: 0;
      width: 50px;
      height: 100%;
      pointer-events: none;
    }

    .left-shadow {
      left: 0;
      background: linear-gradient(to right, rgba(255, 255, 255, 0.9), transparent);
    }

    .right-shadow {
      right: 0;
      background: linear-gradient(to left, rgba(255, 255, 255, 0.9), transparent);
    }
  </style>
</head>

<body class="bg-white flex justify-center items-center min-h-screen">
  <div class="relative w-[90%] max-w-5xl">
    <!-- Gradient Shadows -->
    <div class="gradient-shadow left-shadow"></div>
    <div class="gradient-shadow right-shadow"></div>

    <div class="carousel-container">
      <div id="carousel" class="carousel-track">
        <?php foreach ($properties as $property): ?>
          <div class="bg-white rounded-md shadow-md border border-gray-200 w-72 h-80 flex-shrink-0">
            <img class="w-full h-48 object-cover rounded-t-lg" src="<?= $property['image'] ?>" alt="Property Image" />
            <div class="p-4">
              <h3 class="text-lg font-semibold mt-2"> <?= $property['property_name'] ?> </h3>
              <p class="text-gray-600 text-sm"> <?= $property['location'] ?> </p>
              <p class="text-gray-800 text-md font-medium"> ₹<?= number_format($property['price']) ?> / month</p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <button onclick="moveSlide(-1)"
      class="absolute -left-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full h-12 w-12 shadow-lg">
      ❮ </button>
    <button onclick="moveSlide(1)"
      class="absolute -right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-lg h-12 w-12">
      ❯ </button>
  </div>

  <script>
    let currentIndex = 0;
    const track = document.getElementById("carousel");
    const cards = document.querySelectorAll(".carousel-track > div");
    const cardWidth = cards[0].offsetWidth + 24; // Adjust for gap

    function moveSlide(direction) {
      const maxIndex = cards.length - 1;
      currentIndex = Math.max(0, Math.min(maxIndex, currentIndex + direction));
      track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    }
  </script>
</body>

</html>