<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "stayease";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch Total Listings (Assuming you have a `listings` table)
$totalListings = $conn->query("SELECT COUNT(*) AS total FROM properties")->fetch_assoc()['total'];

// Fetch Total Users
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM signup")->fetch_assoc()['total'];

// Fetch Total Bookings
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM payments")->fetch_assoc()['total'];

// Fetch Revenue (Total of payment_amount)
$revenue = $conn->query("SELECT SUM(payment_amount) AS total FROM payments WHERE payment_status = 'Successful'")->fetch_assoc()['total'];

// Fetch Users Data
$users = $conn->query("SELECT userID, email, 'Yes' AS verified FROM signup");

// Fetch Recent Payments Data (Joining `users` and `payments`)
$payments = $conn->query("
    SELECT p.payment_id, u.userID, u.full_name, p.transaction_id, p.payment_amount, p.payment_date, p.payment_status
    FROM payments p
    JOIN users u ON p.userID = u.userID
    ORDER BY p.payment_date DESC
    LIMIT 10
");

// Fetch booking count per day
$query = "SELECT 
            DAYNAME(payment_date) AS day, 
            COUNT(payment_id) AS bookings 
          FROM payments 
          WHERE payment_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          GROUP BY day
          ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";

$result = $conn->query($query);

// Prepare data array
$bookingsData = [];
$categories = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

$dayBookings = array_fill_keys($categories, 0); // Initialize all days with 0

while ($row = $result->fetch_assoc()) {
  $dayBookings[$row["day"]] = $row["bookings"];
}

// Convert to JSON for JavaScript
$bookingsJson = json_encode(array_values($dayBookings));

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <!-- Link to Tailwind CSS -->
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <!-- Google Fonts for Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-gray-50 p-6 font-Nrj-fonts">
  <div class="container mx-auto">
    <!-- Top Stats -->
    <div class="flex flex-row gap-6 mb-6">
      <div
        class=" w-full bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300">
        <h3 class="text-gray-600"><i class="fa-regular fa-house text-for mr-2"></i>Total Listings</h3>
        <p class="text-3xl font-bold text-gray-900"><?php echo $totalListings; ?></p>
      </div>
      <div
        class=" w-full bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300">
        <h3 class="text-gray-600"><i class="fa-regular fa-user text-for mr-2"></i>Total Users</h3>
        <p class="text-3xl font-bold text-gray-900"><?php echo $totalUsers; ?></p>
      </div>
      <div
        class="w-full bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300">
        <h3 class="text-gray-600"><i class="fa-light fa-file-invoice-dollar text-for mr-2"></i>Total Bookings</h3>
        <p class="text-3xl font-bold text-gray-900"><?php echo $totalBookings; ?></p>
      </div>
      <div
        class=" w-full bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300">
        <h3 class="text-gray-600"><i class="fa-regular fa-chart-line-up text-for mr-2"></i>Revenue</h3>
        <p class="text-3xl font-bold text-green-600">₹<?php echo number_format($revenue, 2); ?></p>

      </div>
    </div>

    <!-- Users Information -->
    <div class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300 mb-6">
      <h3 class="text-xl font-semibold text-gray-700">Users Information</h3>
      <table class="w-full mt-4 text-left border-collapse">
        <thead>
          <tr class="bg-for text-white uppercase text-sm rounded-md">
            <th class="py-2 px-4 rounded-tl-md">User ID</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4 rounded-tr-md">Account Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = $users->fetch_assoc()) { ?>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-2 px-4"><?php echo $user['userID']; ?></td>
              <td class="py-2 px-4"><?php echo $user['email']; ?></td>
              <td class='py-4 px-6 text-sm text-gray-800 font-medium'>
                Verified <i class='fa-solid fa-badge-check text-blue-600 ml-2'></i>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300 mb-6">
      <h3 class="text-xl font-semibold text-gray-700 mb-4">
        Recent Transactions
      </h3>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-for text-white uppercase text-sm">
            <th class="py-3 px-4 rounded-tl-md">User ID</th>
            <th class="py-3 px-4">Name</th>
            <th class="py-3 px-4">Transaction ID</th>
            <th class="py-3 px-4">Amount</th>
            <th class="py-3 px-4">Date</th>
            <th class="py-3 px-4 rounded-tr-md">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($payment = $payments->fetch_assoc()) { ?>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4"><?php echo $payment['userID']; ?></td>
              <td class="py-3 px-4"><?php echo $payment['full_name']; ?></td>
              <td class="py-3 px-4"><?php echo $payment['transaction_id']; ?></td>
              <td class="py-3 px-4">₹<?php echo number_format($payment['payment_amount'], 2); ?></td>
              <td class="py-3 px-4"><?php echo date("d M Y", strtotime($payment['payment_date'])); ?></td>
              <td
                class="py-3 px-4 font-semibold <?php echo ($payment['payment_status'] == 'successful') ? 'text-green-600' : 'text-yellow-600'; ?>">
                <?php echo $payment['payment_status']; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300">
      <h3 class="text-xl font-semibold text-gray-700">Booking Trends</h3>
      <div id="bookingChart" class="mt-4"></div>
    </div>
  </div>

  <script>
    var options = {
      chart: {
        type: "area",
        height: 350,
        toolbar: { show: false },
      },
      series: [
        {
          name: "Bookings",
          data: <?php echo $bookingsJson; ?>

        },
      ],
      xaxis: {
        categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      },
      colors: ["#3B82F6"],
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.2,
          stops: [0, 90, 100],
        },
      },
    };

    var chart = new ApexCharts(
      document.querySelector("#bookingChart"),
      options
    );
    chart.render();
  </script>
</body>

</html>