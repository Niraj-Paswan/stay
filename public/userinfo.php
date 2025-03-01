<?php
// Start session to access user data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "stayease";

$conn = new mysqli($servername, $username, $password, $dbname);

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

// Fetch user details including rent start date
$userID = $_SESSION['userID'];
$sql = "SELECT u.full_name, u.phone_number, u.gender, u.email_address, u.rent_start_date,
               p.payment_id, p.transaction_id, p.payment_date, p.payment_amount, 
               p.security_deposit, p.original_rent, p.payment_status, p.payment_method 
        FROM users u 
        LEFT JOIN payments p ON u.userID = p.userID 
        WHERE u.userID = ? 
        ORDER BY p.payment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Determine display name
$displayName = !empty($user['full_name']) ? $user['full_name'] : $email;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile | StayEase</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.0/css/all.css" />
  <style>
    th,
    td {
      white-space: nowrap;
    }

    body {
      background-image: url("../assets/img/beams-home@95.jpg");
      background-size: cover;
      background-position: center;
    }

    .back-button {
      position: absolute;
      top: 16px;
      left: 16px;
    }
  </style>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen font-Nrj-fonts">
  <!-- Back Button -->
  <div class="back-button">
    <button onclick="history.back()" class="flex items-center text-blue-600 font-medium hover:underline">
      <i class="fa-solid fa-arrow-left mr-2"></i> Back
    </button>
  </div>

  <div class="bg-white p-8 rounded-md border-[1.5px] border-gray-300 shadow-md w-[70%] ">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Hey! 👋
      <span class="text-for"><?php echo htmlspecialchars($displayName); ?></span>
    </h2>
    <p class="text-black mb-4 text-start font-semibold">Your Personal information</p>
    <?php if ($user) { ?>
      <div class="mb-4">
        <i class="fa-solid fa-envelope text-gray-600 text-sm mr-1"></i>
        <label class="text-gray-600 font-medium text-sm" for="email">Email </label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"
          class="w-full p-3 border-[1.5px] border-gray-300 rounded-md bg-gray-100 mt-2" disabled>
      </div>

      <div class="mb-4">
        <i class="fa-solid fa-phone text-gray-600 text-sm mr-1"></i>
        <label class="text-gray-600 font-medium text-sm" for="phone">Phone Number </label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>"
          class="w-full p-3 border-[1.5px] border-gray-300 rounded-md bg-gray-100 mt-2" disabled>
      </div>

      <div class="mb-4">
        <i class="fa-solid fa-mars text-gray-600 text-sm mr-1"></i>
        <label class="text-gray-600 font-medium text-sm" for="gender">Gender</label>
        <input type="text" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>"
          class="w-full p-3 border-[1.5px] border-gray-300 rounded-md bg-gray-100 mt-2" disabled>
      </div>
    <?php } else { ?>
      <p class="text-red-500 text-sm font-medium">Data Not Found</p>
    <?php } ?>

    <p class="text-black py-4 text-start font-semibold">Your Recent Bookings</p>

    <div class="overflow-x-auto">
      <table class="w-full border-collapse border border-gray-300 shadow-sm rounded-lg overflow-hidden">
        <thead>
          <tr class="bg-for text-white text-center">
            <th class="p-3 border border-gray-300 rounded-tl-xl font-semibold">Transaction ID</th>
            <th class="p-3 border border-gray-300 font-semibold">Rent Start Date</th>
            <th class="p-3 border border-gray-300 font-semibold">Original Rent</th>
            <th class="p-3 border border-gray-300 font-semibold">Security Deposit</th>
            <th class="p-3 border border-gray-300 font-semibold">Payment Date</th>
            <th class="p-3 border border-gray-300 font-semibold">Method</th>
            <th class="p-3 border border-gray-300 rounded-tr-xl font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0) { // Check if bookings exist
              do { ?>
              <tr class="text-black text-center bg-gray-200 border-gray-600">
                <td class="p-3 border border-gray-300 rounded-bl-xl">
                  <?php echo htmlspecialchars($user['transaction_id'] ?? 'N/A'); ?>
                </td>
                <td class="p-3 border border-gray-300">
                  <?php echo htmlspecialchars($user['rent_start_date'] ?? 'N/A'); ?>
                </td>
                <td class="p-3 border border-gray-300 font-semibold">
                  &#8377;<?php echo htmlspecialchars($user['original_rent'] ?? '0'); ?>
                </td>
                <td class="p-3 border border-gray-300 font-semibold">
                  &#8377;<?php echo htmlspecialchars($user['security_deposit'] ?? '0'); ?>
                </td>
                <td class="p-3 border border-gray-300">
                  <?php echo htmlspecialchars($user['payment_date'] ?? 'N/A'); ?>
                </td>
                <td class="p-3 border border-gray-300">
                  <?php echo htmlspecialchars($user['payment_method'] ?? 'N/A'); ?>
                </td>
                <td class="p-3 border border-gray-300 rounded-br-xl font-semibold text-center 
                <?php echo ($user['payment_status'] == 'successful') ? 'text-green-600' : 'text-red-600'; ?>">
                  <?php echo htmlspecialchars($user['payment_status'] ?? 'N/A'); ?>
                </td>
              </tr>
            <?php } while ($user = $result->fetch_assoc());
            } else { ?>
            <!-- Show message when no bookings exist -->
            <tr>
              <td colspan="7" class="p-4 text-center text-red-500 font-semibold">No Bookings Found</td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>

    <div class="flex justify-center mt-4">
      <button onclick="window.location.href='download.php'"
        class="mt-2 w-[50%] h-12 rounded-md bg-black hover:bg-opacity-80 text-white font-semibold">
        Download <i class="fa-solid fa-folder-arrow-down ml-2"></i>
      </button>
    </div>

  </div>
</body>

</html>