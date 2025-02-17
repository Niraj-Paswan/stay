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

$sql = "SELECT id,property_name, property_location, property_price, latitude, longitude, main_image, property_type, bathrooms, bedrooms, area FROM properties";
$result = $conn->query($sql);

$properties = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $properties[] = [
            "pid" => $row["id"],
            "property_name" => $row["property_name"],
            "location" => $row["property_location"],
            "coordinates" => [(float)$row["longitude"], (float)$row["latitude"]],
            "price" => $row["property_price"],
            "image" => $row["main_image"],
            "type" => $row["property_type"],
            "bathrooms" => $row["bathrooms"] ?? "N/A",
            "bedrooms" => $row["bedrooms"] ?? "N/A",
            "area" => $row["area"] ?? "N/A"
        ];
    }
}

        session_start();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StayEase | Nearby</title>
  <link
    rel="shortcut icon"
    href="../assets/img/stayease logo.svg"
    type="image/x-icon"
  />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <link
    href="https://api.mapbox.com/mapbox-gl-js/v3.9.1/mapbox-gl.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <style>
    .scrollbar-hidden {
      scrollbar-width: none; /* For Firefox */
      -ms-overflow-style: none; /* For Internet Explorer and Edge */
    }

    .scrollbar-hidden::-webkit-scrollbar {
      display: none; /* For Chrome, Safari, and Opera */
    }

    /* Custom styles for hover card */
    .hover-card {
      width: 300px;
      background: white;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .hover-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .hover-card i {
      position: absolute;
      top: 10px;
      right: 10px;
      background: white;
      padding: 5px;
      border-radius: 50%;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      cursor: pointer;
    }

    .hover-card .content {
      padding: 16px;
    }

    .hover-card .content h3 {
      font-size: 18px;
      font-weight: 600;
      color: #333;
    }

    .hover-card .content h2 {
      margin-top: 8px;
      font-size: 16px;
      font-weight: 500;
      color: #555;
    }

    .hover-card .content h2 span {
      color: #080bae;
      font-size: 20px;
      font-weight: 700;
    }

    /* Remove extra white space and background in the popup */
    .mapboxgl-popup-content {
      padding: 0 !important; /* Remove padding */
      background-color: transparent !important; /* Remove the white background */
      border: none !important; /* Remove b/rder */
    }

    .mapboxgl-popup-tip {
      display: none !important; /* Remove the popup arrow */
    }
  </style>
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.1/mapbox-gl.js"></script>
  <link rel="stylesheet" href="../assets/css/styles.css" />
  </head>
  <body class="h-screen font-Nrj-fonts">
  <nav class="w-full h-14 shadow-md bg-white border-b border-gray-300 p-4">
    <p class="font-medium text-lg">
    Your Location is :
    <i class="fa-solid fa-location-dot text-lg text-red-600"></i>
    <!-- Actual Location -->
    <span id="user-location" class="text-lg font-semibold">Loading...</span>
    </p>
  </nav>

  <div class="grid grid-cols-[60%_40%] h-full">
    <!-- Left Section: Vertically Scrollable without Visible Scrollbar -->
    <div class="overflow-y-auto scrollbar-hidden px-10 py-0">
    <h2 class="text-lg font-semibold py-4">Nearby Properties</h2>
    
    <!-- Search Input -->
    <div class="relative w-full mb-4">
  <!-- Input Field Wrapper -->
  <div class="flex items-center border-[1.5px] border-gray-300 rounded-md shadow-sm focus-within:border-gray-500 focus-within:ring-1.5 focus-within:ring-gray-300 overflow-hidden">
    
    <!-- Input Field -->
    <input type="text" id="search-input" placeholder="Search by the City "
      class="w-full p-3 focus:outline-none">

    <!-- Search Button Inside Input -->
    <button onclick="filterProperties()"
      class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-blue-600 transition">
      Search
    </button>

  </div>
</div>


    <div id="properties-list">
    <?php foreach ($properties as $property): ?>
    <div class="property-item flex flex-row border-[1.5px] border-gray-300 rounded-lg overflow-hidden bg-white mb-8 shadow-md transition">
      <!-- Image Section -->
      <div class="relative w-80 h-52">
        <img
          class="w-full h-60 object-cover"
          src="<?= $property['image'] ?>" 
          alt="Property Image"
        />
        
        <!-- Verified Badge -->
        <div class="absolute top-2 right-2 bg-white text-sm font-medium px-2 py-1 text-black flex items-center rounded-sm">
          <i class="fa-solid fa-badge-check mr-1 text-blue-600"></i>
          Verified
        </div>
      </div>

      <!-- Property Info Section -->
      <div class="flex flex-col flex-1 px-6 py-4">
        <!-- Name & Type -->
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-semibold text-gray-800">
        <?= $property['property_name'] ?>
          </h2>
          <div class="text-sm border-[1.5px] bg-gray-50 border-gray-400 px-4 py-2 font-medium rounded-md text-for">
        <?= $property['type'] ?>
          </div>
        </div>

        <!-- Location -->
        <div class="flex items-center mt-1 text-gray-600 text-sm">
          <i class="fa-solid fa-location-dot mr-1"></i>
          <?= $property['location'] ?>
        </div>

        <!-- Price -->
        <h2 class="text-sm font-normal mt-2 text-gray-500">
          Rent from
          <span class="text-black text-lg font-semibold">
          ₹<?= $property['price'] ?>/ 
          </span>
          month
        </h2>

        <!-- Property Features -->
        <div class="flex justify-between mt-2">
          <div class="flex items-center gap-2">
        <i class="fa-light fa-bed text-lg text-blue-500"></i>
        <p class="text-[16px] font-medium text-gray-800">
          <?= $property['bedrooms'] ?> Bedrooms
        </p>
          </div>
          <div class="flex items-center gap-2">
        <i class="fa-light fa-bath text-lg text-blue-500"></i>
        <p class="text-[16px] font-medium text-gray-800">
          <?= $property['bathrooms'] ?> Bathrooms
        </p>
          </div>
          <div class="flex items-center gap-2">
        <i class="fa-light fa-arrows-maximize text-lg text-blue-500"></i>
        <p class="text-[16px] font-medium text-gray-800">
          <?= $property['area'] ?> Sq.ft
        </p>
          </div>
        </div>

        <!-- Action Button -->
        <form action="listingview.php" method="GET">
        <input type="hidden" name="id" value="<?= $property['pid'] ?>">
        <input type="hidden" name="property_name" value="<?= $property['property_name'] ?>">
        <input type="hidden" name="location" value="<?= $property['location'] ?>">
        <input type="hidden" name="price" value="<?= $property['price'] ?>">
        <input type="hidden" name="image" value="<?= $property['image'] ?>">
        <input type="hidden" name="type" value="<?= $property['type'] ?>">
        <input type="hidden" name="bathrooms" value="<?= $property['bathrooms'] ?>">
        <input type="hidden" name="bedrooms" value="<?= $property['bedrooms'] ?>">
        <input type="hidden" name="area" value="<?= $property['area'] ?>">
        <input type="hidden" name="userID" value="<?= $_SESSION['userID'] ?>">
        <input type="hidden" name="user_email" value="<?= $_SESSION['user_email'] ?>">
        <button type="submit" class="w-full mt-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
          Continue
        </button>
      </form>
      </div>
    </div>
    <?php endforeach; ?>
    </div>
    </div>

    <!-- Right Section: Fixed with Map -->
    <div class="bg-transparent p-4 h-full relative">
    <div id="map" class="h-full rounded-md border border-gray-300"></div>
    </div>
  </div>

  <script>
    function filterProperties() {
      const searchInput = document.getElementById('search-input').value.toLowerCase();
      const propertyItems = document.querySelectorAll('.property-item');

      propertyItems.forEach((item) => {
        const location = item.querySelector('.fa-location-dot').nextSibling.textContent.toLowerCase();
        if (location.includes(searchInput)) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    }
    // Initialize Mapbox map
    mapboxgl.accessToken =
      "pk.eyJ1IjoidHlwcm9qZWN0IiwiYSI6ImNtNTZxdWx6bjEwamUyaXMyc2poczd4OHAifQ.tuR-aGDXJdcOWzsmYz4hnw";

    let map = new mapboxgl.Map({
      container: "map", // The ID of the container where the map will be displayed
      style: "mapbox://styles/mapbox/streets-v11", // Default "streets" style
      center: [73.8245, 15.5916], // Coordinates of Mapusa, Goa (default location)
      zoom: 10, // Default zoom level
    });

    // Add navigation controls (zoom and rotation)
    map.addControl(new mapboxgl.NavigationControl());

    // Add Geolocate Control to the map (default "Find Current Location" button)
    const geolocate = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true,
      },
      trackUserLocation: true, // This will keep the location centered
    });

    map.addControl(geolocate);

    // Function to reverse geocode the latitude and longitude to human-readable address
    function reverseGeocode(lat, lon) {
      const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lon},${lat}.json?access_token=${mapboxgl.accessToken}`;

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          const place = data.features[0]?.place_name || "Unknown Location";
          const userLocationElement = document.getElementById("user-location");
          userLocationElement.textContent = place;
        })
        .catch((error) => {
          console.error("Error fetching geocoding data:", error);
          const userLocationElement = document.getElementById("user-location");
          userLocationElement.textContent = "Unable to fetch location";
        });
    }

    // Array of markers fetched from the database
    const markers = <?php echo json_encode($properties); ?>;

    // Function to calculate distance between two coordinates
    function getDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // Radius of the Earth in kilometers
      const dLat = ((lat2 - lat1) * Math.PI) / 180;
      const dLon = ((lon1 - lon2) * Math.PI) / 180;
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
          Math.cos((lat2 * Math.PI) / 180) *
          Math.sin(dLon / 2) *
          Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c; // Distance in kilometers
    }

    // Function to find the nearest marker
    function findNearestMarker(userLat, userLon) {
      let nearestMarker = null;
      let minDistance = Infinity; // Initialize with a large value

      markers.forEach((marker) => {
        const [lon, lat] = marker.coordinates;
        const distance = getDistance(userLat, userLon, lat, lon);
        if (distance < minDistance) {
          nearestMarker = marker;
          minDistance = distance;
        }
      });

      return { nearestMarker, minDistance };
    }

    // Add the markers to the map with hover cards
    markers.forEach((marker) => {
      const popup = new mapboxgl.Popup({
        offset: 25,
        closeButton: false,
      }).setHTML(
        `<div class="hover-card">
          <img src="${marker.image}" alt="Property" />
          <i class="fa-regular fa-xmark"></i>
          <div class="content font-Nrj-fonts">
            <h3 class="font-bold text-lg">${marker.property_name}</h3> 
            <h1 class="font-normal text-sm">${marker.location}</h1> 
            <h2>From <span>₹${marker.price}</span> /Month</h2>
            <p>Distance: ${getDistance(15.5916, 73.8245, marker.coordinates[1], marker.coordinates[0]).toFixed(2)} km</p>
          </div>
        </div>`
      );

      new mapboxgl.Marker({ color: "blue" })
        .setLngLat(marker.coordinates)
        .setPopup(popup) // Add the popup
        .addTo(map);
    });

    // Geolocate event listener
    geolocate.on("geolocate", (event) => {
      const { latitude, longitude } = event.coords;
      reverseGeocode(latitude, longitude);

      // Update map center to user's location
      map.setCenter([longitude, latitude]);

      // Find the nearest marker and open its popup
      const { nearestMarker, minDistance } = findNearestMarker(latitude, longitude);
      if (nearestMarker) {
        const popup = new mapboxgl.Popup({
          offset: 25,
          closeButton: false,
        }).setHTML(
          `<div class="hover-card">
            <img src="${nearestMarker.image}" alt="Property" />
            <i class="fa-regular fa-xmark"></i>
            <div class="content font-Nrj-fonts">
              <h3>${nearestMarker.property_name}</h3>
              <h2>From <span>₹${nearestMarker.price}</span> /Month</h2>
              <p>Distance: ${minDistance.toFixed(2)} km</p>
            </div>
          </div>`
        );

        popup.setLngLat(nearestMarker.coordinates).addTo(map);
      }

      // Update distances for all properties
      markers.forEach((marker, index) => {
        const distance = getDistance(latitude, longitude, marker.coordinates[1], marker.coordinates[0]);
        document.querySelectorAll('.property-distance')[index].textContent = `Distance: ${distance.toFixed(2)} km`;
      });
    });

  </script>
  </body>
</html>
  </script>
  </body>
</html>
