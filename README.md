# StayEase: Room Rental Web Application 🚀

## Description
StayEase is an innovative web application designed to revolutionize the room rental experience. It provides seamless roommate matching, secure communication, and budget management, making it the ultimate solution for students, professionals, and landlords.

### Why StayEase?
- **Motivation:** Simplify the rental process with transparency and efficiency.
- **Purpose:** StayEase connects tenants and landlords, ensuring verified listings and secure transactions for a hassle-free rental experience.
- **Problem Solved:** Eliminates unreliable listings, hidden charges, and difficulty in finding compatible roommates by providing a transparent and efficient platform.
- **Lessons Learned:** Gained expertise in secure authentication, database management, geolocation services, and optimizing user experience for fast-loading, scalable applications.

---

## Table of Contents
- [Key Features](#key-features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Live Demo](#live-demo)
- [Credits](#credits)
- [License](#license)

---

## 🌟 Key Features

### 🏠 Room Rentals & Listings
- **Room Rentals & Sharing**: Choose between renting a full room or sharing options.
- **Security Deposit Management**: Handle deposits with trust and transparency.
- **Interactive Map Integration**: Powered by Mapbox for location-based exploration.
- **Advanced Search Filters**: Find properties by city and amenities.
- **Mobile-Friendly**: Fully responsive design for seamless browsing.
- **Secure Payments**: Integrated with Stripe API for safe transactions.
- **Automatic Receipts**: Users receive an automated receipt upon successful booking.
- **PDF Booking Receipt**: Integrated with FPDF to allow users to download or print booking receipts as PDFs.
- **Email OTP Authentication**: Ensures secure account verification.
- **Admin Dashboard & Reports**: Admins get insights with detailed reports and management tools.

---

## 💻 Tech Stack

### Frontend
- **HTML, JavaScript**: Core web technologies for structure and interactivity.
- **Tailwind CSS**: Utility-first, responsive styling framework.
- **JavaScript (JS)**: Enhances interactivity and handles dynamic content updates.

### Backend
- **PHP**: Efficient and scalable server-side scripting.

### Database
- **MySQL**: Relational database for structured and scalable data storage.

### APIs & Integrations
- **EmailJS**: For automated email notifications.
- **Mapbox API**: Provides advanced geolocation services.
- **Stripe API**: Secure online payment processing.
- **FPDF**: Used to generate downloadable booking receipts as PDFs.

---

## 🛠 Installation
Clone the repository:
```bash
git clone https://github.com/Niraj-Paswan/stayease.git
```

Start Tailwind CSS in watch mode:
```bash
npx tailwindcss -i ./src/styles.css -o ./assets/css/styles.css --watch
```

---

## 📌 Usage

### 🔹 Booking a Room
1. Browse available properties using filters like location, price, and amenities.
2. Select a property to view detailed information and images.
3. Click on the **"Book Now"** button and proceed with the booking.
4. Enter necessary details and make a secure payment via **Stripe API**.
5. Receive an **automatic receipt** and download the **PDF booking receipt**.

### 🔹 Admin Dashboard
1. Login using **admin credentials**.
2. Access **user and booking reports**.
3. Manage **listings, payments, and user verification**.

### 🔹 User Authentication
1. Register with **email OTP verification**.
2. Login securely to access the full features.

### 🔹 Payment & Receipts
1. Pay via **Stripe API** for secure transactions.
2. Automatically receive a **digital receipt**.
3. Download or print the **PDF booking receipt**.

---

## 📂 Project Structure
```plaintext
stayease/
├── .vscode/           # VS Code workspace settings
├── admin/            # Admin dashboard and reports
├── assets/           # Static assets (images, styles, etc.)
├── bookings/         # Booking-related modules
├── fpdf/             # PDF generation using FPDF
├── info/             # Information pages or additional data
├── node_modules/     # Node.js dependencies
├── public/           # Publicly accessible assets
├── src/              # Main source code (frontend/backend)
├── package-lock.json # Dependency lock file
├── package.json      # Node.js package configuration
├── README.md         # Project documentation
├── tailwind.config.js # Tailwind CSS configuration
```

---

## 🌍 Live Demo
[StayEase Live Demo](#) – Explore the platform in action.

---

## 👨‍💻 Developed By
- <a href="https://github.com/Niraj-Paswan" title="View GitHub Profile" target="_blank"><strong>Niraj Paswan</strong></a> (Lead Developer)

## 🤝 Contributors
- <a href="https://github.com/aditi-manjrekar" title="View GitHub Profile" target="_blank"><strong>Aditi Manjrekar</strong></a>

---

## 📝 License
This project is licensed under the **MIT License**.

---

🚀 **Transform room rentals with StayEase today!**

