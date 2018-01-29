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
mix.copyDirectory('resources/assets/img', 'public/assets/img');
mix.copyDirectory('resources/assets/fonts', 'public/assets/fonts');

mix.js('resources/assets/js/app.js', 'public/assets/js')
   .sass('resources/assets/sass/app.scss', 'public/assets/css');

mix.extract([
    'vue',
    'axios',
    'lodash',
    'jquery',
    'popper.js',
    'bootstrap',
    'vue-snotify',
]);

if (mix.inProduction()) {
  mix.version();
}
