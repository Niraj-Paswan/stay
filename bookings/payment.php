<?php
session_start();

// Validate session data
if (!isset($_SESSION['userID'], $_SESSION['property_id'], $_SESSION['property_price'])) {
    die("Error: Required session data is missing.");
}

$property_price = $_SESSION['property_price'];
$security_deposit = $property_price * 0.25;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEase | Payment</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script> <!-- Keep Stripe UI -->
    <style>
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

<body class="bg-gray-100 flex items-center justify-center min-h-screen font-Nrj-fonts">

    <!-- Back Button -->
    <div class="back-button">
        <button onclick="history.back()" class="flex items-center text-blue-600 font-medium hover:underline">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back
        </button>
    </div>

    <div class="w-full max-w-lg bg-white p-6 sm:p-8 rounded-lg border border-gray-300 shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Payment Summary</h2>

        <div class="bg-gray-100 p-5 rounded-lg mb-6">
            <div class="flex justify-between text-sm font-semibold text-gray-500">
                <span>Original Rent</span>
                <span class="text-[16px] font-semibold text-gray-800">₹ <?= number_format($property_price, 2); ?>
                    INR</span>
            </div>
            <hr class="border-gray-300 my-3">
            <div class="flex justify-between items-center text-lg">
                <span class="text-gray-600 text-sm font-semibold">Security Deposit (25%)</span>
                <span class="text-xl font-semibold text-green-600">₹ <?= number_format($security_deposit, 2); ?>
                    INR</span>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-center">Payment Details</h2>

        <form id="payment-form" action="process_payment.php" method="POST">
            <label for="card-element" class="block text-gray-600">Enter Card Details</label>
            <div id="card-element" class="mt-2 p-4 border rounded-md border-gray-300"></div>
            <p id="card-error" class="text-red-500 text-sm mt-1 hidden">Please enter valid card details.</p>
            <p id="payment-status" class="text-gray-500 text-sm mt-1 hidden"></p>

            <button id="submit"
                class="w-full py-3 rounded-md text-white font-semibold bg-blue-600 hover:bg-blue-800 mt-4">
                <i class="fa-solid fa-credit-card mr-2"></i>
                Pay Now ₹ <?= number_format($security_deposit, 2); ?>
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-3">
            By proceeding, you agree to our <a href="#" class="text-blue-600 hover:underline">Terms & Conditions</a>.
        </p>
    </div>

    <script>
        // Stripe UI Initialization
        const stripe = Stripe("pk_test_51QdZIFIsZuG9rUaAUlU1SDR4OPVjRWrXaMJUTji3L5iYn7ZJGOKwfab9SolHF3H6OkAlX6uD8JicEs4eFMxJ153600sMKu54oZ");
        const elements = stripe.elements();
        const card = elements.create("card");
        card.mount("#card-element");

        const form = document.getElementById("payment-form");

        const cardError = document.getElementById("card-error");
        const paymentStatus = document.getElementById("payment-status");

        form.addEventListener("submit", async (event) => {
            event.preventDefault();
            let isValid = true;

            const { token, error } = await stripe.createToken(card);
            if (error) {
                cardError.classList.remove("hidden");
                cardError.textContent = error.message;
                isValid = false;
            } else {
                cardError.classList.add("hidden");
            }

            if (isValid) {
                paymentStatus.textContent = "Processing Payment...";
                paymentStatus.classList.remove("hidden");
                paymentStatus.classList.remove("text-red-500");
                paymentStatus.classList.add("text-gray-500");

                setTimeout(() => {
                    paymentStatus.textContent = "Payment Successful!";
                    paymentStatus.classList.remove("text-gray-500");
                    paymentStatus.classList.add("text-green-500");
                    window.location.href = "process_payment.php";
                }, 2000);
            }
        });
    </script>
</body>

</html>