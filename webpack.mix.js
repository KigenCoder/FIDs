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

//mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css');
//mix.js('resources/js/app.js', 'public/js').vue();
//mix.js('src/app.js', 'dist');
mix.js('resources/js/app.js', 'public/js').vue();
mix.copy('node_modules/bulma/css/bulma.css', 'public/css/styles/bulma.css');
mix.copy('node_modules/bulma/css/bulma.min.css', 'public/css/styles/bulma.min.css');
