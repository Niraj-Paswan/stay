/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./{public,admin,bookings}/**/*.html", // HTML in public, admin, and bookings folders
    "./{user,includes}/**/*.php", // PHP in user and includes folders
    "./src/**/*.{js,css}", // JS and CSS in the src folder
    "./assets/js/**/*.js", // JS in the assets folder
    "./*.php", // PHP in the root
  ],
  theme: {
    extend: {
      colors: {
        for: "#1769ff",
      },
      fontFamily: {
        "Nrj-fonts": ["Poppins", "sans-serif"],
      },
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
    },
  },
  darkMode: "class",
  plugins: [],
};
