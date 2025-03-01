<?php
// Get the latitude and longitude from URL parameters
$latitude = isset($_GET['latitude']) ? floatval($_GET['latitude']) : 0;
$longitude = isset($_GET['longitude']) ? floatval($_GET['longitude']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Location | With Amenities</title>
  <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
  <link href="../assets/css/styles.css" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.9.1/mapbox-gl.css" rel="stylesheet" />
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.1/mapbox-gl.js"></script>
  <style>
    /* Custom styles for the Mapbox popup close button */
    .mapboxgl-popup-close-button {
      width: 36px;
      height: 36px;
      font-size: 20px;
      padding: 8px;
      border: 1px solid #e2e8f0;
    }

    /* Ensure the map container fills its area */
    #map {
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body class="m-0 p-0 grid grid-cols-[300px_1fr] h-screen overflow-hidden font-Nrj-fonts">
  <!-- Sidebar -->
  <div id="sidebar" class="bg-white shadow-lg p-2 overflow-y-auto">
    <div class="category mb-8" id="restaurants">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <h4 class="text-lg font-medium text-gray-700">Restaurants</h4>
          <i class="fa-solid fa-fork-knife text-lg text-red-600"></i>
        </div>
        <span class="text-sm text-gray-500">0 Results</span>
      </div>
      <ul class="space-y-4"></ul>
    </div>
    <div class="category mb-8" id="hospitals">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <h4 class="text-lg font-medium text-gray-700">Hospitals</h4>
          <i class="fa-solid fa-hospital text-lg text-black"></i>
        </div>
        <span class="text-sm text-gray-500">0 Results</span>
      </div>
      <ul class="space-y-4"></ul>
    </div>
    <div class="category mb-8" id="railways">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <h4 class="text-lg font-medium text-gray-700">Railways</h4>
          <i class="fa-solid fa-train text-lg text-green-700"></i>
        </div>
        <span class="text-sm text-gray-500">0 Results</span>
      </div>
      <ul class="space-y-4"></ul>
    </div>
    <div class="category mb-8" id="supermarkets">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <h4 class="text-lg font-medium text-gray-700">Supermarkets</h4>
          <i class="fa-solid fa-cart-shopping text-lg text-yellow-700"></i>
        </div>
        <span class="text-sm text-gray-500">0 Results</span>
      </div>
      <ul class="space-y-4"></ul>
    </div>
  </div>

  <!-- Map -->
  <div id="map" class="flex-1"></div>

  <script>
    // Haversine Formula to calculate distance between two points on Earth
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // Earth's radius in km
      const φ1 = (lat1 * Math.PI) / 180;
      const φ2 = (lat2 * Math.PI) / 180;
      const Δφ = ((lat2 - lat1) * Math.PI) / 180;
      const Δλ = ((lon2 - lon1) * Math.PI) / 180;
      const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
        Math.cos(φ1) * Math.cos(φ2) *
        Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    }

    // Mapbox access token (ensure this token is valid)
    mapboxgl.accessToken = "pk.eyJ1IjoidHlwcm9qZWN0IiwiYSI6ImNtNTZxdWx6bjEwamUyaXMyc2poczd4OHAifQ.tuR-aGDXJdcOWzsmYz4hnw";

    // Define centerCoordinates using dynamic PHP values
    let centerCoordinates = {
      lat: <?= $latitude ?>,
      lng: <?= $longitude ?>
    };
    console.log("Center Coordinates:", centerCoordinates);

    // Initialize the Map using centerCoordinates
    const map = new mapboxgl.Map({
      container: "map",
      style: "mapbox://styles/mapbox/streets-v12",
      center: [centerCoordinates.lng, centerCoordinates.lat],
      zoom: 12,
    });

    // Add Map Controls
    map.addControl(new mapboxgl.NavigationControl(), "top-right");
    map.addControl(new mapboxgl.FullscreenControl(), "top-right");
    map.addControl(
      new mapboxgl.GeolocateControl({
        positionOptions: { enableHighAccuracy: true },
        trackUserLocation: true,
        showUserHeading: true,
      }),
      "top-right"
    );
    map.addControl(new mapboxgl.ScaleControl(), "bottom-right");

    // Add Style Switcher
    const layerList = document.createElement("div");
    layerList.className = "font-Nrj-fonts absolute top-2 left-2 bg-white p-2 rounded shadow z-10";
    const layers = {
      Streets: "mapbox://styles/mapbox/streets-v12",
      Satellite: "mapbox://styles/mapbox/satellite-v9",
      Light: "mapbox://styles/mapbox/light-v11",
      Dark: "mapbox://styles/mapbox/dark-v11",
      Navigation: "mapbox://styles/mapbox/navigation-day-v1",
    };

    for (const layer in layers) {
      const input = document.createElement("div");
      input.className = "mb-2 last:mb-0";
      const radio = document.createElement("input");
      radio.type = "radio";
      radio.name = "rtoggle";
      radio.value = layer;
      radio.id = layer;
      radio.checked = layer === "Streets";
      radio.className = "mr-2";
      const label = document.createElement("label");
      label.htmlFor = layer;
      label.textContent = layer;
      input.appendChild(radio);
      input.appendChild(label);
      layerList.appendChild(input);
      radio.onclick = () => {
        map.setStyle(layers[layer]);
      };
    }
    document.getElementById("map").appendChild(layerList);

    // Build Overpass query using centerCoordinates
    const query = ` 
      [out:json];
      (
        node["amenity"="restaurant"](around:10000, ${centerCoordinates.lat}, ${centerCoordinates.lng});
        node["amenity"="hospital"](around:10000, ${centerCoordinates.lat}, ${centerCoordinates.lng});
        node["railway"="station"](around:10000, ${centerCoordinates.lat}, ${centerCoordinates.lng});
        node["shop"="supermarket"](around:10000, ${centerCoordinates.lat}, ${centerCoordinates.lng});
      );
      out body;
    `;
    const overpassUrl = "https://overpass-api.de/api/interpreter?data=" + encodeURIComponent(query);
    console.log("Overpass URL:", overpassUrl);

    // Fetch nearby amenities from Overpass API
    fetch(overpassUrl)
      .then(response => response.json())
      .then(data => {
        console.log("Overpass API Data:", data);
        const restaurantList = [];
        const hospitalList = [];
        const railwayList = [];
        const supermarketList = [];

        data.elements.forEach(place => {
          const placeName = place.tags.name || "Unnamed Location";
          const placeType = place.tags.amenity || place.tags.railway || place.tags.shop;
          const placeLat = place.lat;
          const placeLng = place.lon;
          const distance = calculateDistance(centerCoordinates.lat, centerCoordinates.lng, placeLat, placeLng).toFixed(2);

          if (placeType === "restaurant" && restaurantList.length < 5) {
            restaurantList.push({ name: placeName, lat: placeLat, lng: placeLng, distance: distance });
          } else if (placeType === "hospital" && hospitalList.length < 5) {
            hospitalList.push({ name: placeName, lat: placeLat, lng: placeLng, distance: distance });
          } else if (placeType === "station" && railwayList.length < 5) {
            railwayList.push({ name: placeName, lat: placeLat, lng: placeLng, distance: distance });
          } else if (placeType === "supermarket" && supermarketList.length < 5) {
            supermarketList.push({ name: placeName, lat: placeLat, lng: placeLng, distance: distance });
          }
        });

        // Update sidebar result counts
        document.querySelector("#restaurants span").textContent = `${restaurantList.length} Results`;
        document.querySelector("#hospitals span").textContent = `${hospitalList.length} Results`;
        document.querySelector("#railways span").textContent = `${railwayList.length} Results`;
        document.querySelector("#supermarkets span").textContent = `${supermarketList.length} Results`;

        // Function to populate each category in the sidebar
        function populateCategory(list, containerId, category, color) {
          const container = document.getElementById(containerId).querySelector("ul");
          list.forEach(place => {
            const listItem = document.createElement("li");
            listItem.classList.add("text-sm", "bg-gray-100", "p-2", "mb-3", "rounded-md", "border-[1.5px]", "border-gray-300", "hover:bg-gray-200", "cursor-pointer");
            listItem.innerText = `${place.name} - ${place.distance} km`;
            container.appendChild(listItem);

            const marker = new mapboxgl.Marker({ color })
              .setLngLat([place.lng, place.lat])
              .setPopup(
                new mapboxgl.Popup({ offset: 25 }).setHTML(
                  `<div class="p-4 bg-transparent">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">${place.name}</h3>
                    <p class="text-sm text-gray-600 mb-4">${category}</p>
                    <div class="flex items-center space-x-2">
                      <i class="fas fa-map-marker-alt text-gray-500"></i>
                      <span class="text-sm text-gray-500">Lat: ${place.lat.toFixed(3)} | Lng: ${place.lng.toFixed(3)}</span>
                      <br/>
                      <span class="text-sm text-gray-500">Distance: ${place.distance} km</span>
                    </div>
                  </div>`
                )
              )
              .addTo(map);

            listItem.addEventListener("click", () => {
              map.flyTo({ center: [place.lng, place.lat], zoom: 14, essential: true });
              marker.togglePopup();
            });
          });
        }

        // Add a marker for the center location
        new mapboxgl.Marker({ color: "#2563eb" })
          .setLngLat([centerCoordinates.lng, centerCoordinates.lat])
          .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<h3 class="text-xl font-semibold text-gray-800">Center Location</h3>`))
          .addTo(map);

        // Populate sidebar categories with fetched results
        populateCategory(restaurantList, "restaurants", "Restaurant", "#ef4444");
        populateCategory(hospitalList, "hospitals", "Hospital", "#000000");
        populateCategory(railwayList, "railways", "Railway", "#22c55e");
        populateCategory(supermarketList, "supermarkets", "Supermarket", "#f59e0b");
      })
      .catch(error => console.error("Error fetching Overpass data:", error));
  </script>
</body>

</html>