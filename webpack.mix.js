const mix = require('laravel-mix');

mix.sass('resources/assets/sass/app.scss', 'public/css')
   .options({
     processCssUrls: false,
     postCss: [
       require('autoprefixer')()
     ]
   });
