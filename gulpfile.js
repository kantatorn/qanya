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

        'bower_components/angular/angular.min.js',
        'bower_components/angular-material/angular-material.min.js',
        'bower_components/angular-animate/angular-animate.min.js',
        'bower_components/angular-aria/angular-aria.min.js',
        'bower_components/angular-cookies/angular-cookies.min.js',
        'bower_components/angular-sanitize/angular-sanitize.min.js',
        'bower_components/angular-translate/angular-translate.min.js',
        'bower_components/angular-messages/angular-messages.js',
        'bower_components/ng-flow/dist/ng-flow-standalone.min.js',
        'bower_components/angular-toastr/dist/angular-toastr.tpls.js',

        //https://github.com/fraywing/textAngular
        'bower_components/textAngular/dist/textAngular-rangy.min.js',
        'bower_components/textAngular/dist/textAngular-sanitize.min.js',

        'bower_components/textAngular/dist/textAngular.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',

        'ng.js',
        'app.js',
        'translate.js',
        'directive.js',
    ]);

    mix.styles([
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/angular-material/angular-material.min.css',
        'bower_components/angular-toastr/dist/angular-toastr.css',
        'bower_components/animate.css/animate.min.css',
        '/bower_components/textAngular/dist/textAngular.css',

        'qanya.css'
    ]);


    //VERSION
    mix.version(['js/all.js','css/all.css']);


    mix.livereload([ 'app/**/*', 'public/**/*',
        'resources/views/**/*',
        'resources/assets/**/*']);

});
