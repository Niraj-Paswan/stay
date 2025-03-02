<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <body class="bg-gray-50 p-6 font-Nrj-fonts">
    <div class="container mx-auto">
      <!-- Top Stats -->
      <div class="grid grid-cols-4 gap-6 mb-6">
        <div
          class="bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300"
        >
          <h3 class="text-gray-600">Total Listings</h3>
          <p class="text-3xl font-bold text-gray-900">4,320</p>
          <p class="text-green-600 text-sm">+8.5% from last week</p>
        </div>
        <div
          class="bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300"
        >
          <h3 class="text-gray-600">Total Users</h3>
          <p class="text-3xl font-bold text-gray-900">1,250</p>
          <p class="text-green-600 text-sm">+3.2% from last week</p>
        </div>
        <div
          class="bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300"
        >
          <h3 class="text-gray-600">Total Bookings</h3>
          <p class="text-3xl font-bold text-gray-900">350</p>
          <p class="text-red-600 text-sm">-1.2% from last week</p>
        </div>
        <div
          class="bg-white p-6 rounded-md shadow-sm flex flex-col justify-between border-[1.5px] border-gray-300"
        >
          <h3 class="text-gray-600">Revenue</h3>
          <p class="text-3xl font-bold text-gray-900">₹12,75,000</p>
          <p class="text-green-600 text-sm">+10.1% from last week</p>
        </div>
      </div>

      <!-- Users Information -->
      <div
        class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300 mb-6"
      >
        <h3 class="text-xl font-semibold text-gray-700">Users Information</h3>
        <table class="w-full mt-4 text-left border-collapse">
          <thead>
            <tr class="bg-for text-white uppercase text-sm rounded-md">
              <th class="py-2 px-4 rounded-tl-md">User ID</th>
              <th class="py-2 px-4">Full Name</th>
              <th class="py-2 px-4">Email</th>
              <th class="py-2 px-4">Phone</th>
              <th class="py-2 px-4 rounded-tr-md">Gender</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-2 px-4">1</td>
              <td class="py-2 px-4">John Doe</td>
              <td class="py-2 px-4">john@example.com</td>
              <td class="py-2 px-4">+91 9876543210</td>
              <td class="py-2 px-4">Male</td>
            </tr>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-2 px-4">2</td>
              <td class="py-2 px-4">Jane Smith</td>
              <td class="py-2 px-4">jane@example.com</td>
              <td class="py-2 px-4">+91 8765432109</td>
              <td class="py-2 px-4">Female</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Recent Transactions -->
      <div
        class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300 mb-6"
      >
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
          Recent Transactions
        </h3>
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-for text-white uppercase text-sm">
              <th class="py-3 px-4 rounded-tl-md">User ID</th>
              <th class="py-3 px-4">Name</th>
              <th class="py-3 px-4">Transaction ID</th>
              <th class="py-3 px-4">Amount</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4 rounded-tr-md">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">1</td>
              <td class="py-3 px-4">John Doe</td>
              <td class="py-3 px-4">ESD234</td>
              <td class="py-3 px-4">₹15,000</td>
              <td class="py-3 px-4">01 Mar 2025</td>
              <td class="py-3 px-4 text-green-600 font-semibold">Completed</td>
            </tr>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">1</td>
              <td class="py-3 px-4">Jane Smith</td>
              <td class="py-3 px-4">ESD234</td>
              <td class="py-3 px-4">₹12,750</td>
              <td class="py-3 px-4">28 Feb 2025</td>
              <td class="py-3 px-4 text-yellow-600 font-semibold">Pending</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Chart Section -->
      <div
        class="bg-white p-6 rounded-md shadow-md border-[1.5px] border-gray-300"
      >
        <h3 class="text-xl font-semibold text-gray-700">Booking Trends</h3>
        <div id="bookingChart" class="mt-4"></div>
      </div>
    </div>

    <script>
      var options = {
        chart: {
          type: "area",
          height: 350,
          toolbar: { show: false },
        },
        series: [
          {
            name: "Bookings",
            data: [500, 1200, 2500, 3500, 4500, 5200, 6000],
          },
        ],
        xaxis: {
          categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        },
        colors: ["#3B82F6"],
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.2,
            stops: [0, 90, 100],
          },
        },
      };

      var chart = new ApexCharts(
        document.querySelector("#bookingChart"),
        options
      );
      chart.render();
    </script>
  </body>
</html>
