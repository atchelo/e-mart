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

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/trackorder.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');

mix.postCss('resources/sass/theme.css', 'public/css').options({
    processCssUrls: false
});

mix.scripts([
    'public/js/jquery.lazy.min.js',
    'public/js/jquery.lazy.plugins.min.js',
    'public/js/bootstrap.bundle.min.js',
    'public/admindesk/vendor/jquery-ui/jquery-ui.min.js',
    'public/front/vendor/js/jquery.validate.min.js',
    'public/admindesk/plugins/pace/pace.min.js',
    'public/front/vendor/js/select2.min.js',
    'public/front/vendor/js/owl.carousel.min.js',
    'public/front/vendor/js/echo.min.js',
    'public/front/vendor/js/jquery.easing-1.3.min.js',
    'public/front/vendor/js/jquery.rateit.min.js',
    'public/front/vendor/js/wow.min.js',
    'public/front/vendor/js/starrating.min.js',
    'public/front/vendor/js/jquery.countdown.min.js',
    'public/js/venom-button.min.js',
    'public/front/vendor/js/sticky.min.js',
    'public/js/search.js',
    'public/js/jquery.mCustomScrollbar.concat.min.js',
    'public/js/frontmaster.js'
], 'public/js/master.js');

