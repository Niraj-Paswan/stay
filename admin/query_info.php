<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "stayease";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all user queries
$sql = "SELECT query_id, name, email, message, submitted_at FROM user_queries ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | User Queries</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="shortcut icon" href="../assets/img/stayease logo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body class="bg-gray-100 text-gray-800 font-Nrj-fonts">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">User Queries</h1>

        <div class="bg-white  rounded-md overflow-hidden border border-gray-300">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-for text-white uppercase text-sm font-semibold">
                        <th class="p-4">Query ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Message</th>
                        <th class="p-4">Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4"><?php echo htmlspecialchars($row['query_id']); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="p-4"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No queries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
// Close connection
$conn->close();
?>