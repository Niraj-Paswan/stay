<?php
session_start();
include '../Database/dbconfig.php';

// Check if the property ID is passed
if (isset($_GET['id'])) {
    $property_id = intval($_GET['id']); // Ensure it's an integer

    // Fetch the property price from the properties table
    $query = "SELECT property_price FROM properties WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $stmt->bind_result($property_price);
    $stmt->fetch();
    $stmt->close();

    // Ensure price is a valid number (since it's stored as varchar)
    $property_price = is_numeric($property_price) ? floatval($property_price) : 5000;
} else {
    // Default value if no ID is provided
    $property_price = 15000;
}

// On click of Confirm Booking button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    $property_id = $_POST['property_id'];
    $booking_option = $_POST['booking_option'];
    $total_amount = floatval($_POST['total_amount']); // Ensure numeric
    $discount_amount = floatval($_POST['discount_amount']); // Ensure numeric
    $actual_rent = floatval($_POST['actual_rent']); // Ensure numeric

    // ✅ Calculate security deposit correctly as 25% of actual rent
    $security_deposit = $actual_rent * 0.25;

    // ✅ Calculate the final payable amount
    $total_payable = $total_amount + $security_deposit - $discount_amount;

    // ✅ Store values in session
    $_SESSION['property_id'] = $property_id;
    $_SESSION['booking_option'] = $booking_option;
    $_SESSION['total_amount'] = $total_amount;
    $_SESSION['discount_amount'] = $discount_amount;
    $_SESSION['security_deposit'] = $security_deposit;
    $_SESSION['total_payable'] = $total_payable;
    $_SESSION['actual_rent'] = $actual_rent;

    header("Location: personal_info.php?id=$property_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StayEase | Room Sharing</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />

    <style>
        .active-option {
            border: 1px solid #2563eb;
            /* Blue Border for Selected Option */
            background-color: #e0f2fe;
            /* Light Blue */
        }

        body {
            background-image: url("../assets/img/beams-home@95.jpg");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen p-6 font-Nrj-fonts">
    <div class="p-4 absolute left-2 top-2">
        <button onclick="history.back()" class="flex items-center text-blue-600 font-medium hover:underline">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back
        </button>
    </div>
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-xl w-full border-[1.5px] border-gray-300">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">
            Choose Your Room Booking Option
        </h2>

        <!-- Booking Options -->
        <form method="POST">
            <input type="hidden" name="property_id" value="<?= $property_id; ?>">
            <input type="hidden" name="total_amount" id="total_amount">
            <input type="hidden" name="discount_amount" id="discount_amount">
            <input type="hidden" name="security_deposit" id="security_deposit">
            <input type="hidden" name="actual_rent" id="actual_rent">

            <!-- Sole Booking -->
            <label id="sole-option"
                class="flex bg-gray-100 p-4 rounded-md mb-4 cursor-pointer hover:bg-gray-200 transition relative">
                <input type="radio" name="booking_option" value="solely" class="hidden" />
                <p
                    class="bg-yellow-100 rounded-md border-[1px] border-gray-300 absolute top-2 right-2 text-sm p-1 text-amber-900">
                    recommended
                </p>

                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-lock text-xl text-blue-700"></i>
                    <div>
                        <span class="block text-lg font-medium text-gray-900">Book Solely</span>
                        <p class="text-gray-700 text-sm mt-1">
                            Pay full rent & full security deposit.
                        </p>
                    </div>
                </div>
            </label>

            <!-- Shared Booking -->
            <label id="share-option"
                class="block bg-gray-100 p-4 rounded-md mb-4 cursor-pointer hover:bg-gray-200 transition relative">
                <input type="radio" name="booking_option" value="Shared" class="hidden" />
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-group text-xl text-blue-700"></i>
                    <div>
                        <span class="block text-lg font-medium text-gray-900">Share Room</span>
                        <p class="text-gray-700 text-sm mt-1">
                            Split rent & security deposit 50-50.
                        </p>
                    </div>
                </div>
            </label>

            <!-- Promo Code Section -->
            <div class="mt-4">
                <label class="block text-gray-700 font-medium mb-1">Apply Promo Code:</label>
                <div class="flex">
                    <input type="text" id="promo-code"
                        class="w-full p-2 border border-gray-300 rounded-l-md shadow-sm focus:ring-blue-500 focus:outline-none focus:border-gray-500"
                        placeholder="Enter promo code" />
                    <button type="button" id="apply-code"
                        class="bg-blue-600 text-white px-4 rounded-r-md hover:bg-blue-700">
                        Apply
                    </button>
                </div>
                <p id="promo-message" class="text-green-600 text-sm mt-1 hidden"></p>
            </div>

            <!-- Rent Summary -->
            <div class="bg-blue-50 border-[1.5px] border-gray-300 text-black p-4 rounded-md mb-4 text-sm mt-5">
                <div class="flex justify-between items-center mb-1">
                    <p class="font-medium">Room Rent:</p>
                    <p class="font-semibold">₹<span id="rent">5000</span></p>
                </div>

                <div class="flex justify-between items-center mb-1">
                    <p class="font-medium">Security Deposit (25% of Rent):</p>
                    <p class="font-semibold">₹<span id="deposit">1250</span></p>
                </div>

                <div class="flex justify-between items-center mb-1">
                    <p class="font-medium">Discount:</p>
                    <p class="font-semibold text-green-600">
                        -₹<span id="discount">0</span>
                    </p>
                </div>

                <div
                    class="border-t-2 border-gray-300 mt-2 pt-2 flex justify-between items-center text-lg font-semibold">
                    <p class="text-gray-800">Total Payable:</p>
                    <p class="text-blue-700">₹<span id="total">6250</span></p>
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" name="confirm_booking"
                class="w-full mt-4 bg-blue-600 text-white py-3 rounded-lg text-lg font-medium hover:bg-blue-700 transition">
                Confirm Booking
            </button>
        </form>
    </div>

    <!-- JavaScript for Real-Time Calculation -->
    <script>
        // Base Rent and Security Deposit Percentage
        const fullRent = <?php echo $property_price; ?>;
        const securityPercentage = 0.25;

        // Elements
        const rentEl = document.getElementById("rent");
        const depositEl = document.getElementById("deposit");
        const totalEl = document.getElementById("total");
        const discountEl = document.getElementById("discount");
        const totalAmountInput = document.getElementById("total_amount");
        const discountAmountInput = document.getElementById("discount_amount");
        const securityDepositInput = document.getElementById("security_deposit");
        const actualRentInput = document.getElementById("actual_rent");

        let discountAmount = 0;

        // Set initial values
        function calculateInitialValues() {
            rentEl.textContent = fullRent;
            depositEl.textContent = Math.round(fullRent * securityPercentage);
            totalEl.textContent = Math.round(fullRent + fullRent * securityPercentage);
            totalAmountInput.value = totalEl.textContent;
            securityDepositInput.value = depositEl.textContent;
            discountAmountInput.value = 0;
            actualRentInput.value = fullRent;
        }
        calculateInitialValues();

        // Function to update amounts dynamically
        function updateAmount(event, rent, deposit) {
            rentEl.textContent = rent;
            depositEl.textContent = deposit;
            totalEl.textContent = Math.max(0, rent + deposit - discountAmount);
            totalAmountInput.value = totalEl.textContent;
            securityDepositInput.value = depositEl.textContent;
            actualRentInput.value = rent;

            // Remove highlight from all and add to selected
            document.querySelectorAll("label").forEach(label => label.classList.remove("active-option"));
            event.currentTarget.classList.add("active-option");
        }

        // Booking Selection
        document.getElementById("sole-option").addEventListener("click", (event) =>
            updateAmount(event, fullRent, Math.round(fullRent * securityPercentage))
        );

        document.getElementById("share-option").addEventListener("click", (event) =>
            updateAmount(event, Math.round(fullRent / 2), Math.round((fullRent / 2) * securityPercentage))
        );

        // Promo Code Logic
        const promoCodes = {
            SAVE10: 10, // 10% discount
            FLAT500: 500 // Flat ₹500 discount
        };

        document.getElementById("apply-code").addEventListener("click", () => {
            const promoInput = document.getElementById("promo-code").value.trim().toUpperCase();
            const promoMessage = document.getElementById("promo-message");

            if (promoCodes[promoInput]) {
                let currentTotal = parseInt(rentEl.textContent) + parseInt(depositEl.textContent);

                if (promoInput.startsWith("SAVE")) {
                    discountAmount = (parseInt(promoCodes[promoInput]) / 100) * currentTotal;
                } else {
                    discountAmount = promoCodes[promoInput];
                }

                discountEl.textContent = Math.round(discountAmount);
                promoMessage.textContent = `✅ Promo code applied! You saved ₹${Math.round(discountAmount)}.`;
                promoMessage.classList.remove("hidden", "text-red-600");
                promoMessage.classList.add("text-green-600");
            } else {
                discountAmount = 0;
                discountEl.textContent = "0";
                promoMessage.textContent = "❌ Invalid promo code.";
                promoMessage.classList.remove("hidden", "text-green-600");
                promoMessage.classList.add("text-red-600");
            }

            totalEl.textContent = Math.round(parseInt(rentEl.textContent) + parseInt(depositEl.textContent) - discountAmount);
            totalAmountInput.value = totalEl.textContent;
            discountAmountInput.value = discountEl.textContent;
        });

        // Set sole option as default selected
        document.getElementById("sole-option").click();
    </script>
</body>

</html>