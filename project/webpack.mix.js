let mix = require('laravel-mix');
require('laravel-mix-purgecss');

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

mix.webpackConfig({
  output: {
    chunkFilename: '[name].js?id=[chunkhash]'
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.runtime.esm.js',
      '@': path.resolve(__dirname, './resources/js'),
    },
    extensions: ['*', '.js', '.vue', '.json'],
  },
})

//Copy images and fonts from 'resources/' to 'public/'
mix.copyDirectory('resources/img', 'public/img');

// Compiling Js
mix.js('resources/js/app.js', 'public/js')
  .extract();

// Compiling Sass
mix.sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [
      require('tailwindcss')('tailwind.config.js')
    ],
  })


if (mix.inProduction()) {
  mix.purgeCss({enabled: true,})
    .version();
}
