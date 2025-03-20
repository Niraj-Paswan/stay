<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment Checkout</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script> <!-- Keep Stripe UI -->
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white shadow-lg rounded-xl p-8 max-w-md w-full border border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">Secure Checkout</h2>

        <!-- Payment Summary -->
        <div class="bg-gray-50 p-4 rounded-md mb-6 border">
            <div class="flex justify-between text-gray-700">
                <span>Room Rent:</span>
                <span>₹<span id="rent">5000</span></span>
            </div>
            <div class="flex justify-between text-gray-700 mt-2">
                <span>Security Deposit:</span>
                <span>₹<span id="deposit">1250</span></span>
            </div>
            <div class="flex justify-between text-green-600 mt-2">
                <span>Discount:</span>
                <span>-₹<span id="discount">0</span></span>
            </div>
            <div class="border-t mt-2 pt-2 flex justify-between font-semibold text-lg text-gray-800">
                <span>Total:</span>
                <span>₹<span id="total">6250</span></span>
            </div>
        </div>

        <!-- Payment Form -->
        <form id="payment-form">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Cardholder Name</label>
                <input type="text" id="card-name"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="John Doe" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Card Number</label>
                <input type="text" id="card-number"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="1234 5678 9012 3456" maxlength="19" required>
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 font-medium">Expiry Date</label>
                    <input type="text" id="expiry-date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="MM/YY" maxlength="5" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 font-medium">CVV</label>
                    <input type="text" id="cvv"
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="123" maxlength="3" required>
                </div>
            </div>

            <label for="card-element" class="block text-gray-600">Enter Card Details</label>
            <div id="card-element" class="mt-2 p-4 border rounded-md border-gray-300"></div>
            <p id="card-error" class="text-red-500 text-sm mt-1 hidden">Please enter valid card details.</p>
            <p id="payment-status" class="text-gray-500 text-sm mt-1 hidden"></p>

            <!-- Pay Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-md text-lg font-medium hover:bg-blue-700 transition">
                Pay ₹<span id="pay-amount">6250</span>
            </button>
        </form>
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

        document.getElementById("card-number").addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "").substring(0, 16);
            value = value.replace(/(.{4})/g, "$1 ").trim();
            e.target.value = value;
        });

        document.getElementById("expiry-date").addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "").substring(0, 4);
            if (value.length > 2) value = value.replace(/(\d{2})/, "$1/");
            e.target.value = value;
        });

        document.getElementById("payment-form").addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Payment Successful! 🎉");
        });
    </script>

</body>

</html>