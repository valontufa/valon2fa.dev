const mix = require('laravel-mix');

mix
  .js('assets/js/main.js', 'assets/js/bundle.js')
  .postCss('assets/css/main.css', 'assets/css/bundle.css', [
    require('tailwindcss'),
    require('autoprefixer'),
  ])
  .options({ processCssUrls: false });
