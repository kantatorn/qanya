var elixir = require('laravel-elixir');

//https://www.npmjs.com/package/laravel-elixir-livereload
require('laravel-elixir-livereload');

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
    mix.sass('app.scss');

    mix.scripts([
       'app.js'
    ]);

    mix.livereload([ 'app/**/*', 'public/**/*',
        'resources/views/**/*',
        'resources/assets/**/*']);

});
