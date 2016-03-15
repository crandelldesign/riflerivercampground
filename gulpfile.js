var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // Build Stylesheet
    mix.sass(
        'stylesheet.scss',
        'public/css/stylesheet.css',
        {
            includePaths: [
                'node_modules/bootstrap-sass/assets/stylesheets/',
                'node_modules/font-awesome/scss/'
            ]
        }
    );
    // Copy Bootstrap's JS
    mix.copy('node_modules/bootstrap-sass/assets/javascripts/*.js', 'resources/assets/js/bootstrap');
    // Build JS
    mix.scripts(
        [
            'jquery-2.2.1.js',
            'bootstrap/bootstrap.js',
            'master.js'
        ],
        'public/js/master.js'
    );
    // Copy Fonts
    mix.copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts/bootstrap');
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

    // Create Build Numbers
    mix.version(['css/stylesheet.css', 'js/master.js']);

    // Copy Fonts and Images for Build Numbers
    mix.copy('node_modules/bootstrap-sass/assets/fonts', 'public/build/fonts/bootstrap');
    mix.copy('node_modules/font-awesome/fonts', 'public/build/fonts');
    mix.copy('public/img', 'public/build/img');
});
