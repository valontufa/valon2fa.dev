module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        blue: { DEFAULT: '#2563EB', light: '#EFF6FF', muted: '#BFDBFE' },
        dark: '#0F0F0F',
        mid: '#4B5563',
        light: '#F9FAFB',
        border: '#E5E7EB',
        green: { DEFAULT: '#16a34a', light: '#f0fdf4', border: '#bbf7d0' },
      },
      fontFamily: {
        mono: ['JetBrains Mono', 'monospace'],
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
