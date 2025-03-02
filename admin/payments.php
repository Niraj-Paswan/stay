<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Records - Admin</title>
    <!-- Tailwind CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="bg-gray-100 font-Nrj-fonts">
    <div class="container mx-auto p-6">
      <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">
        Payment Records
      </h2>

      <div class="overflow-x-auto">
        <table
          class="min-w-full bg-white border border-gray-200 table-auto rounded-lg shadow"
        >
          <!-- Table Header -->
          <thead class="bg-for">
            <tr>
              <th
                class="py-3 px-6 text-left text-sm font-semibold text-white rounded-tl-md"
              >
                User ID
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Payment ID
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Transaction ID
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Original Amount
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Amount Paid
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Payment Method
              </th>
              <th
                class="py-3 px-6 text-left text-sm font-semibold text-white rounded-tr-md"
              >
                Payment Status
              </th>
            </tr>
          </thead>
          <!-- Table Body -->
          <tbody>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">101</td>
              <td class="py-4 px-6 text-sm text-gray-800">PAY4567</td>
              <td class="py-4 px-6 text-sm text-gray-800">TXN123ABC</td>
              <td class="py-4 px-6 text-sm text-gray-800">$1000</td>
              <td class="py-4 px-6 text-sm text-gray-800">$1000</td>
              <td class="py-4 px-6 text-sm text-gray-800">Credit Card</td>
              <td class="py-4 px-6 text-sm text-green-600 font-semibold">
                Successful
              </td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">102</td>
              <td class="py-4 px-6 text-sm text-gray-800">PAY7890</td>
              <td class="py-4 px-6 text-sm text-gray-800">TXN456XYZ</td>
              <td class="py-4 px-6 text-sm text-gray-800">$750</td>
              <td class="py-4 px-6 text-sm text-gray-800">$500</td>
              <td class="py-4 px-6 text-sm text-gray-800">UPI</td>
              <td class="py-4 px-6 text-sm text-red-600 font-semibold">
                Failed
              </td>
            </tr>
            <!-- More rows can be dynamically added here -->
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
