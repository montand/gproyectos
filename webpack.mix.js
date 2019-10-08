const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.scripts([
    'jquery/dist/jquery.js',
    'bootstrap/dist/js/bootstrap.js'
], 'public/js/all.js', 'node_modules');

mix.browserSync({
    proxy: 'gproyectos.test'
});
