<?php
session_start();

// Validate session data
if (!isset($_SESSION['userID'], $_SESSION['property_id'], $_SESSION['property_price'])) {
    die("Error: Required session data is missing.");
}

$property_price = $_SESSION['property_price'];
$security_deposit = $property_price * 0.25;

// Generate random IDs
function generatePaymentId()
{
    return random_int(1000, 9999);
}

function generateTransactionId()
{
    return strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
}

$payment_id = generatePaymentId();
$transaction_id = generateTransactionId();

// Database connection
$conn = new mysqli("localhost:3307", "root", "", "stayease");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Prepare and insert payment data
$query = "INSERT INTO payments (payment_id, userID, property_id, original_rent, security_deposit, payment_amount, transaction_id, payment_date, payment_time) 
          VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), CURTIME())";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param("siiddss", $payment_id, $_SESSION['userID'], $_SESSION['property_id'], $property_price, $security_deposit, $security_deposit, $transaction_id);

if ($stmt->execute()) {
    header("Location: ../public/success.php");
    exit();
} else {
    echo "Error executing query: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>