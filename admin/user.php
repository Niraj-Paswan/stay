<?php
// Database connection
$servername = "localhost:3307";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$database = "stayease";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all users from signup table and check booking status from payments
$sql = "SELECT 
            s.userID, 
            s.email, 
            COALESCE(MAX(p.payment_status), 'Not Booked') AS booking_status
        FROM signup s
        LEFT JOIN payments p ON s.userID = p.userID AND p.payment_status = 'successful'
        GROUP BY s.userID, s.email";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registered Users - Admin</title>
  <!-- Tailwind CSS -->
  <link href="../assets/css/styles.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body class="bg-gray-100 font-Nrj-fonts">
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">
      Registered Users
    </h2>

    <div class="overflow-x-auto">
      <table class="w-full bg-white border border-gray-200 table-auto rounded-lg shadow overflow-hidden">
        <!-- Table Header -->
        <thead class="bg-blue-600 text-white rounded-t-lg">
          <tr>
            <th class="py-3 px-6 text-left text-sm font-bold uppercase">User ID</th>
            <th class="py-3 px-6 text-left text-sm font-bold uppercase">Email</th>
            <th class="py-3 px-6 text-left text-sm font-bold uppercase">Account Status</th>
            <th class="py-3 px-6 text-left text-sm font-bold uppercase">Bookings</th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr class='border-b border-gray-200'>";
              echo "<td class='py-4 px-6 text-sm text-gray-800'>{$row['userID']}</td>";
              echo "<td class='py-4 px-6 text-sm text-gray-800'>{$row['email']}</td>";
              echo "<td class='py-4 px-6 text-sm text-gray-800 font-medium'>
        Verified <i class='fa-solid fa-badge-check text-blue-600 ml-2'></i>
      </td>";

              if ($row['booking_status'] == 'successful') {
                echo "<td class='py-4 px-6 text-sm text-green-600 font-semibold'>Booked</td>";
              } else {
                echo "<td class='py-4 px-6 text-sm text-red-600 font-semibold'>Not Booked</td>";
              }
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='py-4 px-6 text-sm text-gray-800 text-center'>No users found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>