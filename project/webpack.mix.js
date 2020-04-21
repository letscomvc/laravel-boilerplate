let mix = require('laravel-mix');
let path = require('path');

mix.webpackConfig({
  output: {
    chunkFilename: 'js/[name].js?id=[chunkhash]'
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.runtime.esm.js',
      '@': path.resolve(__dirname, './resources/assets/js'),
    },
    extensions: ['*', '.js', '.vue', '.json'],
  },
})

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
mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');

//Compiling assets
mix.js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .version()
