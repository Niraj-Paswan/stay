<?php
session_start();

// Validate session data
$required_session_keys = ['userID', 'property_id', 'total_payable', 'actual_rent', 'security_deposit', 'discount_amount', 'booking_option'];
foreach ($required_session_keys as $key) {
    if (!isset($_SESSION[$key])) {
        die("Error: Missing required session data ($key).");
    }
}

// Fetch session values
$userID = intval($_SESSION['userID']);
$property_id = intval($_SESSION['property_id']);
$original_rent = floatval($_SESSION['actual_rent']);
$security_deposit = floatval($_SESSION['security_deposit']);
$discount_amount = floatval($_SESSION['discount_amount']);
$total_payable = floatval($_SESSION['total_payable']);
$booking_type = ($_SESSION['booking_option'] === 'Shared') ? 'Shared Booking' : 'Solely Booked';

// Generate Unique IDs
$payment_id = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10)); // 10-character ID
$transaction_id = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6)); // 6-character ID

// Database connection
$conn = new mysqli("localhost:3307", "root", "", "stayease");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Prepare and insert payment data
$query = "INSERT INTO payments 
    (payment_id, userID, property_id, payment_method, original_rent, security_deposit, discount_amount, total_payable, payment_amount, transaction_id, booking_type) 
VALUES 
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$payment_method = 'Debit Card'; // Default method

$stmt->bind_param(
    "siisddddsss",
    $payment_id,
    $userID,
    $property_id,
    $payment_method,
    $original_rent,
    $security_deposit,
    $discount_amount,
    $total_payable,
    $total_payable, // payment_amount = total_payable
    $transaction_id,
    $booking_type
);

if ($stmt->execute()) {
    $_SESSION['transaction_id'] = $transaction_id;
    header("Location: booking_receipt.php");
    exit();
} else {
    die("Error executing query: " . $stmt->error);
}

// Close connections
$stmt->close();
$conn->close();
?>