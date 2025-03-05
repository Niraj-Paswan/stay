<?php

session_start(); // Start session

// Database connection
$host = "localhost:3307";
$username = "root";
$password = "";
$database = "stayease";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Check if the property ID is passed
if (isset($_GET['id'])) {
  $property_id = intval($_GET['id']); // Change from pid to id

  // Secure integer conversion
  $sql = "SELECT id, property_name, property_location, property_price, property_description, 
                 latitude, longitude, main_image, kitchen_img, washroom_img, gallery_img, 
                 property_type, bathrooms, bedrooms, area 
          FROM properties WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $property_id);
  $stmt->execute();
  $result = $stmt->get_result();

  $properties = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $properties[] = [
        "pid" => $row["id"],
        "property_name" => $row["property_name"],
        "location" => $row["property_location"],
        "coordinates" => [(float) $row["longitude"], (float) $row["latitude"]],
        "price" => $row["property_price"],
        "des" => $row["property_description"],
        "image" => $row["main_image"],
        "kitchen" => $row["kitchen_img"],
        "washroom" => $row["washroom_img"],
        "bedroomimg" => $row["gallery_img"],
        "type" => $row["property_type"],
        "bathrooms" => $row["bathrooms"] ?? "N/A",
        "bedrooms" => $row["bedrooms"] ?? "N/A",
        "area" => $row["area"] ?? "N/A"
      ];
      // Set session variables
      $_SESSION['property_id'] = $row["id"];
      $_SESSION['property_price'] = $row["property_price"];
      $_SESSION['property_name'] = $row["property_name"];
    }
  } else {
    echo "Property not found!";
    exit;
  }
} else {
  echo "No property selected!";
  exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/css/styles.css" rel="stylesheet" />
  <title>StayEase | Property Listing</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <style>
    /* Rotate the second icon when it has the rotate-180 class */
    .rotate-180 {
      transform: rotate(180deg);
      transition: transform 0.3s ease-in-out;
    }

    /* Fixed position for the first icon */
    .icon-fixed {
      transform: rotate(0deg);
    }

    /* Custom Styles for hiding and showing elements */
  </style>
</head>

<body>
  <?php if (!empty($properties)): ?>
    <a href="listingview.php?pid=<?= $properties[0]['pid'] ?>"></a>
  <?php endif; ?>

  <div class="h-full w-full bg-white font-Nrj-fonts">
    <div class="container mx-auto p-4">
      <!-- Main Content Section -->
      <div class="flex flex-wrap lg:flex-nowrap gap-6">
        <!-- Left Section -->
        <div class="flex-1" id="property_gallery">
          <!-- Property Image Gallery -->
          <div class="bg-white p-4 border-[1.5px] border-gray-300 rounded-lg h-[100%]" id="image_gallery">
            <!-- Main Image -->
            <?php foreach ($properties as $property): ?>
              <div class="relative w-full h-80 rounded-lg overflow-hidden" id="main_image_container">
                <img src="<?= $property['image'] ?>" alt="Room Image" class="w-full h-full object-cover" name="main_image"
                  id="main_image" />
              </div>
              <!-- Thumbnails -->
              <div class="grid grid-cols-3 gap-4 mt-4" id="thumbnails">
                <div class="relative w-full h-44 rounded-lg overflow-hidden border-[1.5px] border-gray-300">

                  <img src="<?= $property['kitchen'] ?>" alt="Thumbnail" class="w-full h-full object-cover"
                    name="thumbnail_1" id="thumbnail_1" />
                  <div class="absolute bottom-0 w-full bg-gray-200 p-2 text-center text-sm font-medium">
                    Kitchen
                  </div>
                </div>
                <div class="relative w-full h-44 rounded-lg overflow-hidden border-[1.5px] border-gray-300">
                  <img src="<?= $property['bedroomimg'] ?>" alt="Thumbnail" class="w-full h-full object-cover"
                    name="thumbnail_2" id="thumbnail_2" />
                  <div class="absolute bottom-0 w-full bg-gray-200 p-2 text-center text-sm font-medium">
                    Bedroom
                  </div>
                </div>
                <div class="relative w-full h-44 rounded-lg overflow-hidden border-[1.5px] border-gray-300">
                  <img src="<?= $property['washroom'] ?>" alt="Thumbnail" class="w-full h-full object-cover"
                    name="thumbnail_3" id="thumbnail_3" />
                  <div class="absolute bottom-0 w-full bg-gray-200 p-2 text-center text-sm font-medium">
                    Washroom
                  </div>
                </div>
              </div>

              <!-- Property Title and Location -->
              <h2 class="text-2xl font-semibold text-gray-800 mt-6 flex flex-row justify-between"
                id="property_title_container">
                <span name="property_title" id="property_title"> <?= $property['property_name'] ?></span>
              </h2>
              <div class="flex flex-row items-center justify-start mr-12" id="property_location_container">
                <p class="text-gray-600 font-medium text-sm">
                  <i class="fa-regular fa-location-dot text-sm mr-1"></i>
                  <span name="property_location" id="property_location"><?= $property['location'] ?></span>
                </p>
              </div>
              <div class="flex flex-row justify-between  mt-4">
                <!-- Type Section -->
                <div
                  class="flex items-center gap-2 border-[1.5px] border-gray-400 bg-white rounded-md px-4 py-2 shadow-sm">
                  <i class="fa-regular fa-house text-for text-sm"></i>
                  <span class="text-black text-sm font-medium">Type</span>
                  <span class="text-gray-500">|</span>
                  <span class="text-sm font-medium text-for"><?= $property['type'] ?></span>
                </div>
                <!-- Sharable Section -->
                <div
                  class="flex items-center gap-2 border-[1.5px] border-gray-400 bg-white rounded-md px-4 py-2 shadow-sm">
                  <i class="fa-regular fa-user-group text-for text-sm"></i>
                  <span class="text-black text-sm font-medium">Sharable</span>
                  <span class="text-gray-500">|</span>
                  <span class="text-sm font-medium text-for">Max 2 People</span>
                </div>

                <!-- Status Section -->
                <div
                  class="flex items-center gap-2 border-[1.5px] border-gray-400 bg-white rounded-md px-4 py-2 shadow-sm">
                  <i class="fa-regular fa-circle-check text-for text-sm"></i>
                  <span class="text-black text-sm font-medium ">Status</span>
                  <span class="text-gray-500">|</span>
                  <span class="text-sm font-medium text-for">Vacant</span>
                  <i class="fa-solid fa-circle text-xs text-green-600"></i>
                </div>
              </div>


            </div>
          </div>

          <!-- Right Section -->
          <div class="w-full h-[100%] lg:w-1/3 bg-white p-4 rounded-lg border-[1.5px] border-gray-300 shadow-sm"
            data-property-id="1" data-property-name="Suddha Apartment" data-rent-price="15000" data-rent-duration="month"
            data-verified="1">
            <h2 class="text-lg font-semibold text-gray-800  flex flex-row justify-between mb-2">
              <?= $property['property_name'] ?>
              <div class="text-sm font-medium bg-gray-50 border-[1.5px] border-gray-300 rounded-md p-1 px-2  text-black"
                data-verified="1">
                <i class="fa-solid fa-badge-check mr-1 text-blue-600"></i>Verified
              </div>
            </h2>
            <h2 class="text-sm font-normal mb-2 text-gray-500">
              Rent from
              <span class="text-black text-lg font-semibold">₹<?= $property['price'] ?>/</span> month
            </h2>
            <!-- Action Buttons -->
            <button class="w-full py-2 bg-blue-500 text-white font-medium rounded hover:bg-for mb-4"
              data-action="continue" onclick="window.location.href = '../bookings/personal_info.php';" ;>
              Continue
            </button>
            <button class="w-full py-2 bg-gray-200 text-gray-700 font-medium rounded hover:bg-gray-300"
              data-action="go-back" onclick="window.history.back();">
              Go Back
            </button>
            <!-- Shortlisted Info -->

            <!-- Collapsible Section -->
            <div class="mt-6">
              <h3 class="text-xl font-semibold text-gray-800 mb-4">
                Why Choose This Property?
              </h3>
              <!-- Collapsible Items -->
              <div class="collapsible-item border-t border-gray-300">
                <button type="button" class="toggle-button w-full flex justify-between items-center py-4 text-left"
                  onclick="toggleContent('feature1', this.querySelector('.rotate-icon'))" data-feature-id="1">
                  <span class="flex items-center text-sm font-medium text-gray-800 gap-4">
                    <div
                      class="icon-wrapper w-9 h-9 bg-blue-200 bg-opacity-25 rounded-full flex justify-center items-center">
                      <i class="fa-light fa-calendar-check text-[16px] text-for"></i>
                    </div>
                    Instant Booking
                  </span>
                  <i class="rotate-icon fa-solid fa-caret-down mr-4 text-sm text-gray-500"></i>
                </button>
                <div id="feature1" class="hidden px-4 py-2 text-gray-600 text-sm"
                  data-feature-description="Instant booking allows you to quickly book the property by paying the amount.">
                  Instant booking allows you to quickly book the property by
                  paying the amount.
                </div>
              </div>

              <div class="collapsible-item border-t border-gray-300">
                <button type="button" class="toggle-button w-full flex justify-between items-center py-4 text-left"
                  onclick="toggleContent('feature2', this.querySelector('.rotate-icon'))" data-feature-id="2">
                  <span class="flex items-center text-sm font-medium text-gray-800 gap-4">
                    <div
                      class="icon-wrapper w-9 h-9 bg-blue-200 bg-opacity-25 rounded-full flex justify-center items-center">
                      <i class="fa-light fa-hand-holding-dollar text-[16px] text-for"></i>
                    </div>
                    Lowest Price Guaranteed
                  </span>
                  <i class="rotate-icon fa-solid fa-caret-down mr-4 text-sm text-gray-500"></i>
                </button>
                <div id="feature2" class="hidden px-4 py-2 text-gray-600 text-sm"
                  data-feature-description="We ensure you get the lowest price for your stay.">
                  We ensure you get the lowest price for your stay.
                </div>
              </div>

              <div class="collapsible-item border-t border-gray-300">
                <button type="button" class="toggle-button w-full flex justify-between items-center py-4 text-left"
                  onclick="toggleContent('feature3', this.querySelector('.rotate-icon'))" data-feature-id="3">
                  <span class="flex items-center text-sm font-medium text-gray-800 gap-4">
                    <div
                      class="icon-wrapper w-9 h-9 bg-blue-200 bg-opacity-25 rounded-full flex justify-center items-center">
                      <i class="fa-light fa-circle-check text-[16px] text-for"></i>
                    </div>
                    Verified Listings
                  </span>
                  <i class="rotate-icon fa-solid fa-caret-down mr-4 text-sm text-gray-500"></i>
                </button>
                <div id="feature3" class="hidden px-4 py-2 text-gray-600 text-sm"
                  data-feature-description="Our listings are thoroughly verified to ensure your safety and comfort.">
                  Our listings are thoroughly verified to ensure your safety and
                  comfort.
                </div>
              </div>

              <div class="collapsible-item border-t border-gray-300">
                <button type="button" class="toggle-button w-full flex justify-between items-center py-4 text-left"
                  onclick="toggleContent('feature4', this.querySelector('.rotate-icon'))" data-feature-id="4">
                  <span class="flex items-center text-sm font-medium text-gray-800 gap-4">
                    <div
                      class="icon-wrapper w-9 h-9 bg-blue-200 bg-opacity-25 rounded-full flex justify-center items-center">
                      <i class="fa-light fa-tag text-[16px] text-for"></i>
                    </div>
                    Instant Discounts
                  </span>
                  <i class="rotate-icon fa-solid fa-caret-down mr-4 text-sm text-gray-500"></i>
                </button>
                <div id="feature4" class="hidden px-4 py-2 text-gray-600 text-sm"
                  data-feature-description="Enjoy instant discounts on your Booking, save more with every deal, no waiting required!">
                  Enjoy instant discounts on your Booking, save more with every
                  deal, no waiting required!
                </div>
              </div>

              <div class="collapsible-item border-t border-gray-300">
                <button type="button" class="toggle-button w-full flex justify-between items-center py-4 text-left"
                  onclick="toggleContent('feature5', this.querySelector('.rotate-icon'))" data-feature-id="5">
                  <span class="flex items-center text-sm font-medium text-gray-800 gap-4">
                    <div
                      class="icon-wrapper w-9 h-9 bg-blue-200 bg-opacity-25 rounded-full flex justify-center items-center">
                      <i class="fa-light fa-eye-slash text-[16px] text-for"></i>
                    </div>
                    No hidden charges
                  </span>
                  <i class="rotate-icon fa-solid fa-caret-down mr-4 text-sm text-gray-500"></i>
                </button>
                <div id="feature5" class="hidden px-4 py-2 text-gray-600 text-sm"
                  data-feature-description="Negotiate prices effortlessly to get the best deal that suits your budget!">
                  Transparent pricing with no unexpected fees or extra costs.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- About Property Section -->
        <div class="sm:w-full lg:w-[100%] bg-white border border-gray-300 rounded-lg mt-4" data-property-id="1">
          <!-- Section Title -->
          <div class="py-3 px-4 border-b border-gray-300">
            <h2 class="font-semibold text-[16px] text-gray-800">
              About The Property
            </h2>
          </div>
          <div class="p-4">
            <!-- Property Description -->
            <p class="text-sm font-normal text-gray-700 mb-4 leading-relaxed"
              data-property-description="Experience modern rental room apartments situated in the serene state of Goa, offering a perfect blend of comfort, convenience, and style. These apartments feature essential amenities like spacious interiors, high-speed internet, and fully equipped kitchens, all designed to cater to your everyday needs. Located in prime areas close to beaches, markets, and major attractions, they provide a hassle-free living experience for both long and short-term stays.">
              <?= $property['des'] ?>
            </p>
            <!-- Key Features -->
            <div class="flex justify-start items-start gap-24 mb-2">
              <div class="flex items-center gap-2" data-bedrooms="2">
                <i class="fa-light fa-bed text-lg text-blue-500"></i>
                <p class="text-[16px] font-medium text-gray-800"><?= $property['bedrooms'] ?> Bedrooms</p>
              </div>
              <div class="flex items-center gap-2" data-bathrooms="1">
                <i class="fa-light fa-bath text-lg text-blue-500"></i>
                <p class="text-[16px] font-medium text-gray-800"><?= $property['bathrooms'] ?> Bathroom
              </div>
              <div class="flex items-center gap-2" data-size="1800">
                <i class="fa-light fa-arrows-maximize text-lg text-blue-500"></i>
                <p class="text-[16px] font-medium text-gray-800"><?= $property['area'] ?> Sq.ft</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Room Amenties -->
        <div class="sm:w-full lg:w-[100%] h-[50%] mt-4 bg-white border-[1.5px] border-gray-300 rounded-lg"
          data-room-id="101">
          <h2 class="text-lg lg:text-[16px] font-medium py-2 ml-4" data-section="room-includes">
            Room Includes
            <span class="ml-2 text-[14px] font-normal bg-green-600 text-white rounded-full px-3 py-1">Amenities</span>
          </h2>
          <p class="border-b border-gray-300"></p>

          <div class="flex flex-row justify-between py-2 text-gray-600 mr-12" data-bills-included="true">
            <h2 class="font-medium text-sm lg:text-[15px] py-2 ml-4" data-item="bills-included">
              Bills included
            </h2>
            <div class="flex justify-center items-center flex-row gap-2" data-item-id="water">
              <i class="fa-light fa-glass-water-droplet text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="water">Water</h2>
            </div>

            <div class="flex justify-center items-center flex-row gap-2" data-item-id="electricity">
              <i class="fa-light fa-plug text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="electricity">Electricity</h2>
            </div>

            <div class="flex justify-center items-center flex-row gap-2" data-item-id="fan">
              <i class="fa-light fa-fan-table text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="fan">Fan</h2>
            </div>
          </div>
          <p class="border-b border-gray-300"></p>

          <div class="flex flex-row justify-between py-2 text-gray-600 mr-12" data-common-amenities="true">
            <h2 class="font-medium text-sm lg:text-[15px] py-2 ml-4" data-item="common-amenities">
              Common Amenities
            </h2>
            <div class="flex justify-center items-center flex-row gap-2 mr-0 lg:mr-12" data-item-id="parking">
              <i class="fa-light fa-car-garage text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="parking">Parking</h2>
            </div>

            <div class="flex justify-center items-center flex-row gap-2" data-item-id="cctv">
              <i class="fa-light fa-camera-cctv text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="cctv">CCTV</h2>
            </div>

            <div class="flex justify-center items-center flex-row gap-2" data-item-id="alarm">
              <i class="fa-light fa-siren-on text-sm lg:text-xl"></i>
              <h2 class="text-sm" data-item-name="alarm">Alarm</h2>
            </div>
          </div>
        </div>

        <!-- Payment Policy -->
        <div class="sm:w-full lg:w-[100%] h-[50%] bg-white border-[1.5px] border-gray-300 rounded-lg mt-4"
          data-policy-id="101">
          <!-- Payment Policy Title (Clickable to toggle dropdown) -->
          <div
            class="accordion-header flex flex-row justify-start items-center gap-2 w-full cursor-pointer py-3 px-4 hover:bg-gray-100"
            data-section="payment-policies">
            <h2 class="text-[16px] font-medium ml-2">Payment Policies</h2>
            <!-- Dropdown Icon -->
            <i class="fa-solid fa-caret-down ml-auto text-gray-500" id="dropdown-icon" data-toggle="true"></i>
          </div>
          <p class="border-b border-gray-300"></p>

          <!-- Dropdown Content (Initially hidden) -->
          <div class="accordion-content hidden" data-accordion-content="true">
            <!-- Booking Deposit Section -->
            <div class="flex flex-col justify-start items-start pt-1 border-b border-gray-300 hover:bg-gray-100"
              data-policy-id="deposit">
              <div class="flex flex-row justify-center items-center gap-2">
                <i class="fa-regular fa-circle-check text-green-600 text-xl ml-4" data-icon="checkmark"></i>
                <div class="flex flex-col justify-start items-start">
                  <h2 class="text-[16px] font-medium ml-2" data-policy-name="booking-deposit">
                    Booking Deposit
                  </h2>
                  <p class="text-sm font-light ml-2 text-gray-500 mb-2" data-policy-description="deposit">
                    This property requires a booking deposit of
                    <span class="font-medium text-gray-600" data-deposit-amount="25%">25%</span>
                    of the
                    <span class="font-medium text-gray-600">rent amount.</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Mode of Payment Section -->
            <div class="flex flex-col justify-start items-start pt-1 border-b border-gray-300 hover:bg-gray-100"
              data-policy-id="mode-of-payment">
              <div class="flex flex-row justify-center items-center gap-2">
                <i class="fa-regular fa-circle-check text-green-600 text-xl ml-4" data-icon="checkmark"></i>
                <div class="flex flex-col justify-start items-start">
                  <h2 class="text-[16px] font-medium ml-2" data-policy-name="mode-of-payment">
                    Mode of Payment
                  </h2>
                  <p class="text-sm font-light ml-2 text-gray-500 mb-2" data-policy-description="mode">
                    Payment via
                    <span class="font-medium text-gray-600">easy transaction</span>
                    modes.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Cancellation Policy -->
        <div class="sm:w-full lg:w-[100%] h-[50%] bg-white border-[1.5px] border-gray-300 rounded-lg mt-4"
          data-policy-id="cancellation">
          <!-- Cancellation Policy Title (Clickable to toggle dropdown) -->
          <div
            class="accordion-header-cancellation flex flex-row justify-start items-center gap-2 w-full cursor-pointer py-3 px-4 hover:bg-gray-100"
            data-section="cancellation-policies">
            <h2 class="text-[16px] font-medium ml-2">Cancellation Policies</h2>
            <!-- Dropdown Icon -->
            <i class="fa-solid fa-caret-down ml-auto text-gray-500" id="dropdown-icon-cancellation"
              data-toggle="true"></i>
          </div>
          <p class="border-b border-gray-300"></p>

          <!-- Dropdown Content (Initially hidden) -->
          <div class="accordion-content-cancellation hidden" data-accordion-content="true">
            <!-- Refund Section -->
            <div class="flex flex-col justify-start items-start pt-1 border-b border-gray-300 hover:bg-gray-100"
              data-policy-id="refund">
              <div class="flex flex-row justify-center items-center gap-2">
                <i class="fa-regular fa-circle-check text-green-600 text-xl ml-4" data-icon="checkmark"></i>
                <div class="flex flex-col justify-start items-start">
                  <h2 class="text-[16px] font-medium ml-2" data-policy-name="refund">
                    Refund
                  </h2>
                  <p class="text-sm font-light ml-2 text-gray-500 mb-2" data-policy-description="refund">
                    The remaining
                    <span class="font-medium text-gray-600" data-refund-amount="2%">2% will be charged</span>
                    and the remaining amount will be refunded.
                  </p>
                </div>
              </div>
            </div>

            <!-- Cancellation Payment Section -->
            <div class="flex flex-col justify-start items-start pt-1 hover:bg-gray-100"
              data-policy-id="cancellation-payment">
              <div class="flex flex-row justify-center items-center gap-2">
                <i class="fa-regular fa-circle-check text-green-600 text-xl ml-4" data-icon="checkmark"></i>
                <div class="flex flex-col justify-start items-start">
                  <h2 class="text-[16px] font-medium ml-2" data-policy-name="cancellation-payment">
                    Cancellation Payment
                  </h2>
                  <p class="text-sm font-light ml-2 text-gray-500 mb-2" data-policy-description="payment">
                    Payment will be transferred to the
                    <span class="font-medium text-gray-600" data-payment-duration="2-days">account within 2 days</span>
                    to the original account.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Location Section -->
        <div class="sm:w-full lg:w-[100%] h-[50%] bg-white border-[1.5px] border-gray-300 rounded-lg mt-4"
          data-section="location">
          <!-- Section Title -->
          <h2 class="font-medium text-[16px] py-3 ml-4" data-title="locations-and-nearby">
            Locations and Nearby
          </h2>
          <p class="border-b border-gray-300"></p>

          <!-- Embedded Map (iframe) -->
          <!-- Embedded Map (iframe) -->
          <!-- In your listing view page -->
          <iframe id="mapFrame" class="w-full h-[450px] border-gray-300 rounded-md p-4" src=""></iframe>

          <script>
            // Assuming you have the coordinates from PHP (from your $properties array)
            var latitude = <?= $properties[0]['coordinates'][1] ?>;
            var longitude = <?= $properties[0]['coordinates'][0] ?>;

            // Build the URL with query parameters
            var mapUrl = "map_index.php?latitude=" + latitude + "&longitude=" + longitude;

            // Set the iframe's src to load the dynamic map
            document.getElementById("mapFrame").src = mapUrl;
          </script>


        </div>
      </div>
    </div>

    <footer class="bg-black font-Nrj-fonts mt-6">
      <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0 ml-14 md:ml-0 lg:ml-0">
            <a href="#" id="brands" class="font-Nrj-fonts font-semibold text-md flex items-center ml-2">
              <img class="max-w-10 max-h-44 ml-5" src="../assets/img/stayease logo.svg" alt="" />
              <p class="font-Nrj-fonts ml-2 text-xl text-white">StayEase</p>
            </a>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
            <div>
              <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">
                Resources
              </h2>
              <ul class="text-white dark:text-gray-400 font-medium">
                <li class="mb-4">
                  <a href="#" class="hover:underline">StayEase</a>
                </li>
                <li>
                  <a href="#" class="hover:underline">Blog</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">
                Follow us
              </h2>
              <ul class="text-white dark:text-gray-400 font-medium">
                <li class="mb-4">
                  <a href="https://github.com/Niraj-Paswan" class="hover:underline">Github</a>
                </li>
                <li>
                  <a href="https://discord.gg" class="hover:underline">Discord</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 class="mb-6 text-sm font-semibold text-for uppercase dark:text-white">
                Legal
              </h2>
              <ul class="text-white dark:text-gray-400 font-medium">
                <li class="mb-4">
                  <a href="#" class="hover:underline">Privacy Policy</a>
                </li>
                <li>
                  <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2025 <a href="#"
              class="hover:underline">StayEase™</a>. All
            Rights Reserved.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">
            <a href="#" class="text-white hover:text-for dark:hover:text-white">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 8 19">
                <path fill-rule="evenodd"
                  d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                  clip-rule="evenodd" />
              </svg>
              <span class="sr-only">Facebook page</span>
            </a>
            <a href="#" class="text-white hover:text-for dark:hover:text-white ms-5">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 17">
                <path fill-rule="evenodd"
                  d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                  clip-rule="evenodd" />
              </svg>
              <span class="sr-only">Twitter page</span>
            </a>
            <a href="https://github.com/Niraj-Paswan/stay" class="text-white hover:text-for dark:hover:text-white ms-5">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                  clip-rule="evenodd" />
              </svg>
              <span class="sr-only">GitHub account</span>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </body>

  <!-- JavaScript to toggle collapsible sections -->
  <script>
    // Toggles the visibility of collapsible sections and rotates the caret icon
    function toggleContent(id, icon) {
      const content = document.getElementById(id);
      content.classList.toggle("hidden");

      // Rotate the second icon (animate the rotation)
      icon.classList.toggle("rotate-180");
    }
    // First section's JavaScript (Booking Policies)
    const accordionHeader = document.querySelector(".accordion-header");
    const accordionContent = document.querySelector(".accordion-content");
    const dropdownIcon = document.getElementById("dropdown-icon");

    accordionHeader.addEventListener("click", () => {
      accordionContent.classList.toggle("hidden");
      // Toggle dropdown icon (caret up/down)
      if (accordionContent.classList.contains("hidden")) {
        dropdownIcon.classList.remove("fa-caret-up");
        dropdownIcon.classList.add("fa-caret-down");
      } else {
        dropdownIcon.classList.remove("fa-caret-down");
        dropdownIcon.classList.add("fa-caret-up");
      }
    });

    // Second section's JavaScript (Cancellation Policies)
    const accordionHeaderCancellation = document.querySelector(
      ".accordion-header-cancellation"
    );
    const accordionContentCancellation = document.querySelector(
      ".accordion-content-cancellation"
    );
    const dropdownIconCancellation = document.getElementById(
      "dropdown-icon-cancellation"
    );

    accordionHeaderCancellation.addEventListener("click", () => {
      accordionContentCancellation.classList.toggle("hidden");
      // Toggle dropdown icon (caret up/down)
      if (accordionContentCancellation.classList.contains("hidden")) {
        dropdownIconCancellation.classList.remove("fa-caret-up");
        dropdownIconCancellation.classList.add("fa-caret-down");
      } else {
        dropdownIconCancellation.classList.remove("fa-caret-down");
        dropdownIconCancellation.classList.add("fa-caret-up");
      }
    });
  </script>

  </html>
<?php endforeach; ?>