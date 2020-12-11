const mix = require('laravel-mix');

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
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        options: {
          formatter: require('eslint-friendly-formatter'),
        },
        exclude: /node_modules/,
      },
    ],
  },
});

mix.js('resources/js/app.js', 'public/js').extract(['vue', 'axios', 'lodash', 'lang.js', '@fortawesome/fontawesome-free']).sass('resources/sass/app.scss', 'public/css');

// mix.langjs();

if (mix.inProduction()) {
  mix.version();
  mix.sourceMaps();
} else {
  mix.browserSync('mini-crm.localhost');
}

