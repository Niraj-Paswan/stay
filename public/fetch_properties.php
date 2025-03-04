<?php
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "stayease";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed");
}

$properties = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['city'])) {
    $city = $conn->real_escape_string($_POST['city']);
    $query = "SELECT property_name, property_location, property_price FROM properties WHERE property_location LIKE '%$city%' ORDER BY property_price ASC LIMIT 10";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Find Your Property</h2>
        <form method="POST" class="relative">
            <input name="city" type="text" placeholder="Enter City"
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="absolute right-2 top-2 px-4 py-2 bg-blue-500 text-white rounded-md">Search</button>
        </form>
        <div class="mt-4 space-y-3">
            <?php if (!empty($properties)): ?>
                <?php foreach ($properties as $property): ?>
                    <div class='bg-gray-50 p-4 border rounded-md shadow-md'>
                        <h3 class='text-lg font-bold text-gray-700'><?= htmlspecialchars($property['property_name']) ?></h3>
                        <p class='text-sm text-gray-600'><?= htmlspecialchars($property['property_location']) ?></p>
                        <p class='text-sm text-blue-600 font-semibold'>₹<?= htmlspecialchars($property['property_price']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <p class='text-red-500 text-center'>No properties found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>