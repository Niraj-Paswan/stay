<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registered Users - Admin</title>
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
        Registered Users
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
                Name
              </th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-white">
                Email
              </th>
              <th
                class="py-3 px-6 text-left text-sm font-semibold text-white rounded-tr-md"
              >
                Bookings
              </th>
            </tr>
          </thead>
          <!-- Table Body -->
          <tbody>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">1</td>
              <td class="py-4 px-6 text-sm text-gray-800">John Doe</td>
              <td class="py-4 px-6 text-sm text-gray-800">
                johndoe@example.com
              </td>
              <td class="py-4 px-6 text-sm text-green-600">Booked</td>
            </tr>
            <tr class="border-b border-gray-200">
              <td class="py-4 px-6 text-sm text-gray-800">2</td>
              <td class="py-4 px-6 text-sm text-gray-800">Jane Smith</td>
              <td class="py-4 px-6 text-sm text-gray-800">
                janesmith@example.com
              </td>
              <td class="py-4 px-6 text-sm text-red-600">NA</td>
            </tr>
            <!-- More rows can be added dynamically -->
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
