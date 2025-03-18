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
$userID = $_SESSION['userID'];
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
               p.security_deposit, p.original_rent, p.payment_status, p.payment_method,p.total_payable,p.booking_type,p.discount_amount
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

// Function to get user initials for avatar
function getInitials($name)
{
  $words = explode(' ', $name);
  $initials = '';
  foreach ($words as $word) {
    $initials .= strtoupper(substr($word, 0, 1));
  }
  return $initials;
}
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
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1769ff', // This matches the "for" class in the original
          },
          fontFamily: {
            'poppins': ['Poppins', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    body {
      background-image: url("../assets/img/beams-home@95.jpg");
      background-size: cover;
      background-position: center;
      font-family: 'Poppins', sans-serif;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .tab-button.active {
      background-color: white;
      color: #3b82f6;
      font-weight: 600;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="bg-white min-h-screen p-8 md:p-8">
  <!-- Back Button -->
  <button onclick="history.back()"
    class="mb-6 flex items-center text-blue-600 font-medium hover:bg-gray-100 p-2 rounded-md">
    <i class="fa-solid fa-arrow-left mr-2"></i> Back
  </button>
  <div class="max-w-6xl mx-auto bg-white p-8 border border-gray-300 rounded-lg">


    <!-- Profile header -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8">
      <div
        class="h-20 w-20 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold border-2 border-primary">
        <?php echo getInitials($displayName); ?>
      </div>
      <div>
        <h1 class="text-2xl font-bold text-gray-800">
          Hey 👋 <?php echo htmlspecialchars($displayName); ?>
        </h1>
        <p class="text-gray-500">Welcome to your StayEase profile</p>
      </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
      <div class="grid grid-cols-2 max-w-md bg-gray-50 p-1 rounded-md border-[1.5px] border-gray-300">
        <button id="tab-personal" class="tab-button active py-2 px-4 rounded-sm text-sm font-medium transition-colors">
          Personal Information
        </button>
        <button id="tab-bookings" class="tab-button py-2 px-4 rounded-sm text-sm font-medium transition-colors">
          Your Bookings
        </button>
      </div>
    </div>

    <!-- Personal Information Tab -->
    <div id="content-personal" class="tab-content active space-y-6">
      <div class="bg-gray-50 rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold flex items-center">
            <i class="fa-regular fa-user mr-2"></i> Personal Information
          </h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-500">Email Address</label>
              <div class="p-3 bg-gray-50 rounded-md border-[1.5px] border-gray-300 text-gray-800 font-medium">
                <?php echo htmlspecialchars($email); ?>
              </div>
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-500">Phone Number</label>
              <div class="p-3 bg-gray-50 rounded-md border-[1.5px] border-gray-300 text-gray-800 font-medium">
                <?php echo htmlspecialchars($user['phone_number'] ?? 'N/A'); ?>
              </div>
            </div>

            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-500">Gender</label>
              <div class="p-3  bg-gray-50 rounded-md border-[1.5px] border-gray-300 text-gray-800 font-medium">
                <?php echo htmlspecialchars($user['gender'] ?? 'N/A'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bookings Tab -->
    <div id="content-bookings" class="tab-content space-y-6">
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
          <h2 class="text-xl font-semibold">Recent Bookings</h2>
        </div>
        <div class="p-6">
          <?php if ($result->num_rows > 0) {
            // Reset the result pointer
            $result->data_seek(0);
            while ($booking = $result->fetch_assoc()) { ?>
              <div class="border rounded-lg overflow-hidden mb-6">
                <div class="bg-blue-50 p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                  <div>
                    <p class="text-sm text-gray-500">Transaction ID</p>
                    <p class="font-medium"><?php echo htmlspecialchars($booking['transaction_id'] ?? 'N/A'); ?></p>
                  </div>
                  <div>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                      <?php echo ($booking['payment_status'] == 'successful')
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800'; ?>">
                      <?php echo htmlspecialchars($booking['payment_status'] ?? 'N/A'); ?>
                    </span>
                  </div>
                </div>

                <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                  <div>
                    <p class="text-sm text-gray-500">Rent Start Date</p>
                    <p class="font-medium"><?php echo htmlspecialchars($booking['rent_start_date'] ?? 'N/A'); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Booking Type</p>
                    <p class="font-medium"><?php echo htmlspecialchars($booking['booking_type'] ?? 'N/A'); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Payment Date</p>
                    <p class="font-medium"><?php echo htmlspecialchars($booking['payment_date'] ?? 'N/A'); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="font-medium"><?php echo htmlspecialchars($booking['payment_method'] ?? 'N/A'); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Original Rent</p>
                    <p class="font-medium">₹<?php echo number_format($booking['original_rent'] ?? 0); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Security Deposit</p>
                    <p class="font-medium">₹<?php echo number_format($booking['security_deposit'] ?? 0); ?></p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Discount Amount</p>
                    <p class="font-medium text-green-600">₹<?php echo number_format($booking['discount_amount'] ?? 0); ?>
                    </p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-500">Total Paid</p>
                    <p class="font-semibold text-lg">₹<?php echo number_format($booking['total_payable'] ?? 0); ?></p>
                  </div>
                </div>
              </div>
            <?php }
          } else { ?>
            <div class="text-center py-8">
              <p class="text-red-500 font-medium">No Bookings Found</p>
            </div>
          <?php } ?>

          <div class="mt-6 flex justify-center">
            <button onclick="window.location.href='download.php'"
              class="w-full max-w-md bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-md flex items-center justify-center">
              <i class="fa-solid fa-arrow-down-to-bracket mr-2"></i> Download Booking Details
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function () {
      const tabButtons = document.querySelectorAll('.tab-button');
      const tabContents = document.querySelectorAll('.tab-content');

      tabButtons.forEach(button => {
        button.addEventListener('click', function () {
          // Remove active class from all buttons and contents
          tabButtons.forEach(btn => btn.classList.remove('active'));
          tabContents.forEach(content => content.classList.remove('active'));

          // Add active class to clicked button
          this.classList.add('active');

          // Get the content id based on the button id
          const contentId = 'content-' + this.id.split('-')[1];
          document.getElementById(contentId).classList.add('active');
        });
      });
    });
  </script>
</body>

</html>