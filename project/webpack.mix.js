let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//Copy images and fonts from 'resources/' to 'public/'
mix.copyDirectory('resources/assets/img', 'public/assets/img');
mix.copyDirectory('resources/assets/fonts', 'public/assets/fonts');

//Compiling assets
mix.js('resources/assets/js/app.js', 'public/assets/js')
   .sass('resources/assets/sass/app.scss', 'public/assets/css');

// Third party libraries in vendor.js
mix.extract([
    'vue',
    'axios',
    'lodash',
    'jquery',
    'popper.js',
    'bootstrap',
    'vue-snotify',
    'jquery-mask-plugin',
]);

// Versioning assets when production
if (mix.inProduction()) {
  mix.version();
}
