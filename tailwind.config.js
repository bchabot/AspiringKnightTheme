/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./assets/js/src/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'primary': 'var(--ak-primary-color)',
        'accent': 'var(--ak-accent-gold)',
        'site-bg': 'var(--ak-site-bg)',
        'header-bg': 'var(--ak-header-bg)',
        'footer-bg': 'var(--ak-footer-bg)',
        'body-text': 'var(--ak-body-text)',
        'heading-text': 'var(--ak-heading-text)',
        'link': 'var(--ak-link-color)',
        'link-hover': 'var(--ak-link-hover-color)',
        'knight-iron': '#3a3a3a',
        'knight-gold': '#d4af37',
        'knight-crimson': '#8b0000',
      },
    },
  },
  plugins: [],
}