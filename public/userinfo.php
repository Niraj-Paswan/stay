<?php
// Start session to access user data
session_start();

// Check if the user is logged in (userID should be stored in session)
if (!isset($_SESSION['userID'])) {  // Fix: Changed user_id to userID
    header('Location: login.php');  // Redirect to login if not logged in
    exit();
}

// Database connection
$servername = "localhost:3307"; 
$username = "root";           
$password = "";               
$dbname = "stayease";       

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch user email
$userID = $_SESSION['userID'];  // Fix: Changed user_id to userID
$sql = "SELECT email FROM signup WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Fetch user bookings
$booking_sql = "SELECT * FROM booking WHERE userID = ? ORDER BY Booking_date DESC";
$booking_stmt = $conn->prepare($booking_sql);
$booking_stmt->bind_param("i", $userID);
$booking_stmt->execute();
$bookings_result = $booking_stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile | StayEase</title>
    <link
      rel="shortcut icon"
      href="../assets/img/stayease logo.svg"
      type="image/x-icon"
    />
    <!-- External CSS and Fonts -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
  </head>

  <body
    class="bg-gray-100 flex justify-center items-center min-h-screen font-poppins bg-cover bg-center font-Nrj-fonts"
    style="background-image: url('../assets/img/beams-home@95.jpg')"
  >
    <!-- White Container -->
    <div
      class="p-8 w-full sm:w-1/2 md:w-2/3 lg:w-[50%] bg-white border border-gray-300 rounded-xl shadow-lg mx-4"
    >
      <!-- Header -->
      <h2 class="text-3xl font-semibold text-black mb-6 text-center">
        Hey! 👋 <span class="text-blue-600"><?php echo htmlspecialchars($email); ?></span>
      </h2>

      <p class="text-sm font-medium text-gray-600 text-center">
        Here are your Personal Information
      </p>
      <!-- Email & User ID Section -->
      <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
          Your Email
        </label>
        <input
          type="email"
          name="email"
          id="email"
          value="<?php echo htmlspecialchars($email); ?>"
          disabled
          class="w-full p-3 border-[0.5px] border-gray-200 rounded-md text-gray-700 bg-gray-100"
        />
      </div>
      <div class="mb-6">
        <label
          for="userid"
          class="block text-sm font-medium text-gray-700 mb-1"
        >
          Your User ID
        </label>
        <input
          type="text"
          name="userid"
          id="userid"
          value="<?php echo htmlspecialchars($userID); ?>"
          disabled
          class="w-full p-3 border-[0.5px] border-gray-200 rounded-md text-gray-700 bg-gray-100"
        />
      </div>

      <!-- Bookings Section -->
      <p class="text-lg font-semibold text-gray-800 mb-3">
        Your Recent Bookings
      </p>
      <div class="overflow-x-auto">
        <table
          class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg overflow-hidden"
        >
          <thead>
            <tr class="bg-gray-100 text-gray-800 border border-gray-300">
              <th class="px-3 py-2 border border-gray-300 rounded-tl-lg">
                Booking ID
              </th>
              <th class="px-3 py-2 border border-gray-300">Booking Date</th>
              <th class="px-3 py-2 border border-gray-300">Rent Amount</th>
              <th class="px-3 py-2 border border-gray-300">Start Date</th>
              <th class="px-3 py-2 border-r-2 border-gray-300">SD Paid</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($booking = $bookings_result->fetch_assoc()) { ?>
              <tr class="text-center bg-white border-b-2 hover:bg-gray-50 transition rounded-lg">
                <td class="px-3 py-2 border-l-2 border-gray-300"><?php echo $booking['BookingID']; ?></td>
                <td class="px-3 py-2 border border-gray-300"><?php echo $booking['Booking_date']; ?></td>
                <td class="px-3 py-2 border border-gray-300"><?php echo '$' . $booking['Security_deposite']; ?></td>
                <td class="px-3 py-2 border border-gray-300"><?php echo $booking['Ten_start_date']; ?></td>
                <td class="px-3 py-2 border-r-2 rounded-br-lg border-gray-300">
                  <?php echo '$' . $booking['Security_deposite']; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- Download Button -->
      <div class="mt-6 text-center">
        <button
          class="flex items-center justify-center gap-2 bg-black hover:bg-opacity-85 rounded-md text-white px-6 py-3 rounded-mdtransition w-full sm:w-1/2 mx-auto"
        >
          Download <i class="fa-regular fa-folder-arrow-down"></i>
        </button>
      </div>
    </div>
  </body>
</html>
