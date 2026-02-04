/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./assets/js/src/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'knight-iron': '#3a3a3a',
        'knight-gold': '#d4af37',
        'knight-crimson': '#8b0000',
      },
    },
  },
  plugins: [],
}