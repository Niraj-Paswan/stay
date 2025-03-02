<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Details - Admin</title>
    <!-- Link to Tailwind CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link
      rel="shortcut icon"
      href="../assets/img/stayease logo.svg"
      type="image/x-icon"
    />
    <!-- Font Awesome for icons -->
    <link
      rel="stylesheet"
      href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css"
    />
    <!-- Google Fonts for Poppins -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="bg-gray-100 font-Nrj-fonts">
    <div class="w-full bg-gray-100 p-8">
      <!-- Section Title -->
      <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
        Booking Details
      </h2>

      <!-- Booking Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 table-auto">
          <!-- Table Header -->
          <thead>
            <tr class="bg-for">
              <th
                class="py-3 px-6 text-left text-sm font-semibold text-white rounded-tl-md"
              >
                User ID
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Transaction ID
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Name
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Email
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Property Name
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Rent Start Date
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Next Due Date
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Booking Status
              </th>
              <th
                class="py-3 px-6 text-left text-sm font-semibold text-white rounded-tr-md"
              >
                Payment Method
              </th>
            </tr>
          </thead>
          <!-- Table Body -->
          <tbody>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">1</td>
              <td class="py-4 px-6 text-sm text-gray-800">TXN123</td>
              <td class="py-4 px-6 text-sm text-gray-800">John Doe</td>
              <td class="py-4 px-6 text-sm text-gray-800">
                johndoe@example.com
              </td>
              <td class="py-4 px-6 text-sm text-gray-800">Suite</td>
              <td class="py-4 px-6 text-sm text-gray-800">2024-12-01</td>
              <td class="py-4 px-6 text-sm text-gray-800">2025-02-04</td>
              <td class="py-4 px-6 text-sm text-gray-800">Confirmed</td>
              <td class="py-4 px-6 text-sm text-gray-800">Credit Card</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">2</td>
              <td class="py-4 px-6 text-sm text-gray-800">TXN654</td>
              <td class="py-4 px-6 text-sm text-gray-800">Jane Smith</td>
              <td class="py-4 px-6 text-sm text-gray-800">
                janesmith@example.com
              </td>
              <td class="py-4 px-6 text-sm text-gray-800">Double Room</td>
              <td class="py-4 px-6 text-sm text-gray-800">2024-12-03</td>
              <td class="py-4 px-6 text-sm text-gray-800">2025-02-04</td>
              <td class="py-4 px-6 text-sm text-gray-800">Pending</td>
              <td class="py-4 px-6 text-sm text-gray-800">PayPal</td>
            </tr>
            <!-- More rows can be added here -->
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
