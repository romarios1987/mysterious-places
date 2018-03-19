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

/**
 * Подключаем все файлы для бэкенда
 */
mix.styles([
    'resources/assets/backend/bootstrap/css/bootstrap.min.css',
    'resources/assets/backend/font-awesome/4.5.0/css/font-awesome.min.css',
    'resources/assets/backend/ionicons/2.0.1/css/ionicons.min.css',
    'resources/assets/backend/plugins/iCheck/minimal/_all.css',
    'resources/assets/backend/plugins/datepicker/datepicker3.css',
    'resources/assets/backend/plugins/select2/select2.min.css',
    'resources/assets/backend/plugins/datatables/dataTables.bootstrap.css',
    'resources/assets/backend/dist/css/AdminLTE.min.css',
    'resources/assets/backend/dist/css/skins/_all-skins.min.css'
], 'public/css/admin.css');

mix.scripts([
    'resources/assets/backend/plugins/jQuery/jquery-2.2.3.min.js',
    'resources/assets/backend/bootstrap/js/bootstrap.min.js',
    'resources/assets/backend/plugins/select2/select2.full.min.js',
    'resources/assets/backend/plugins/datepicker/bootstrap-datepicker.js',
    'resources/assets/backend/plugins/datatables/jquery.dataTables.min.js',
    'resources/assets/backend/plugins/datatables/dataTables.bootstrap.min.js',
    'resources/assets/backend/plugins/slimScroll/jquery.slimscroll.min.js',
    'resources/assets/backend/plugins/fastclick/fastclick.js',
    'resources/assets/backend/plugins/iCheck/icheck.min.js',
    'resources/assets/backend/dist/js/app.min.js',
    'resources/assets/backend/dist/js/demo.js',
    'resources/assets/backend/dist/js/scripts.js'
], 'public/js/admin.js');

// Копируем шрифты в папку public
mix.copy('resources/assets/backend/bootstrap/fonts', 'public/fonts');
mix.copy('resources/assets/backend/dist/fonts', 'public/fonts');

// Копируем картинки в папку public
mix.copy('resources/assets/backend/dist/img', 'public/img');

mix.copy('resources/assets/backend/plugins/iCheck/minimal/blue.png', 'public/css');


