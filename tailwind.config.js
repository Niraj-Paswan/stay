/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.php",
    "./public/**/*.html",
    "./admin/**/*.php",
    "./admin/**/*.html",
    "./bookings/**/*.{php,html}",
    "./user/**/*.php",
    "./includes/**/*.php",
    "./src/**/*.{js,css}",
    "./assets/js/**/*.js",
    "./*.php",
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
