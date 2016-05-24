<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Qanya?</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href='https://fonts.googleapis.com/css?family=Kanit:300&subset=thai,latin' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bower_components/angular-material/angular-material.min.css" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/css/tether.min.css" rel="stylesheet">
    <link href="/css/all.css" rel="stylesheet">

    @if ( Config::get('app.debug') )
        <script type="text/javascript">
            document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
        </script>
    @endif

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body id="app-layout" ng-app="App" layout='row'>

<div layout="column" flex>

    <md-toolbar style="box-shadow: 1px 2px 8px rgba(0, 0, 0, .5);">

        <div class="md-toolbar-tools">

            <md-button class="md-icon-button" aria-label="menu">
                <md-icon md-svg-icon="/icons/ic_menu_white_24px.svg"></md-icon>
            </md-button>

            <h2>
                <a href="/">
                    <span>Qanya</span>
                </a>
            </h2>

            <span flex></span>

            <span flex></span>

            <md-button>
                <md-icon md-svg-icon="/icons/ic_apps_white_24px.svg"></md-icon>
                @{{ 'KEY_DASHBOARD' | translate }}
            </md-button>

            @if(Auth::user())

                {{-- Ask question --}}
                <md-button class=""
                        hide-xs
                        aria-label="@{{ 'KEY_QUESTION' | translate }}"
                        href="/create">
                    <md-icon md-svg-icon="/icons/ic_create_white_24px.svg"></md-icon>
                    @{{ 'KEY_QUESTION' | translate }}
                </md-button>

                <md-button
                        hide-xs
                        aria-label="{!! Auth::user()->displayname !!}"
                        href="/{!! Auth::user()->displayname !!}">
                    {!! Auth::user()->firstname !!}
                    <img ng-src="{!! Auth::user()->avatar !!}" class="img-circle" width="27px">
                </md-button>

            @else

                <md-button class="md-icon-button" aria-label="Person"
                           ng-href="{{ url('/login') }}">
                    <md-icon md-svg-icon="/icons/ic_account_circle_white_24px.svg"></md-icon>
                    <md-tooltip md-direction="left">
                        @{{ 'KEY_LOGIN_REGISTER' | translate }}
                    </md-tooltip>
                </md-button>

            @endif

        </div>

    </md-toolbar>

    {{-- Main container--}}
    <md-content layout-align="center">
        @yield('content')
    </md-content>

</div>




    <!-- JavaScripts -->
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/angular-material/angular-material.min.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.min.js"></script>
    <script src="/bower_components/angular-aria/angular-aria.min.js"></script>
    <script src="/bower_components/angular-cookies/angular-cookies.min.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="/bower_components/angular-translate/angular-translate.min.js"></script>
    <script src="/bower_components/angular-messages/angular-messages.js"></script>


    <!-- Firebase -->
    <script src="https://cdn.firebase.com/js/client/2.4.0/firebase.js"></script>

    <!-- AngularFire -->
    <script src="https://cdn.firebase.com/libs/angularfire/1.2.0/angularfire.min.js"></script>


    <script src="/js/ng.js"></script>
    <script src="/js/translate.js"></script>
    <script src="/js/all.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
