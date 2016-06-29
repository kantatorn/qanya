<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Qanya?</title>

    {{-- SEO STUFF --}}
    {!! SEO::generate() !!}

    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href='https://fonts.googleapis.com/css?family=Kanit:300&subset=thai,latin' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/css/tether.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>


    @if ( Config::get('app.debug') )
        <script type="text/javascript">
            document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
        </script>
    @endif

    <script src="{{ elixir('js/all.js') }}"></script>
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

</head>

<body id="app-layout" ng-app="App" layout='row'>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div layout="column" flex ng-controller="AppCtrl" ng-cloak>

    <md-toolbar style="box-shadow: 1px 2px 8px rgba(0, 0, 0, .5);
                background: white;">

        <div class="md-toolbar-tools">

            {{-- Side bar menu toggle--}}
            <md-button class="md-icon-button md-primary"
                       hide-gt-xs
                       aria-label="menu"
                       ng-click="toggleLeft()">
                <md-icon>
                    <i class="material-icons">menu</i>
                </md-icon>
            </md-button>


            <span>
                <a href="/" class="purple-font">
                    <img src="/icons/qanya.gif" width="40px" class="img-fluid">
                </a>
            </span>


            <span flex></span>

            {{-- Channels --}}
            <md-button
                       hide-xs
                       aria-label="@{{ 'KEY_DASHBOARD' | translate }}"
                       ng-click="toggleRight()">
                <span class="purple-font">
                    <md-icon>
                        <i class="material-icons purple-font">apps</i>
                    </md-icon>
                    @{{ 'KEY_DASHBOARD' | translate }}
                </span>
            </md-button>

            @if(Auth::user())

                @if(Auth::user()->init_setup)

                {{-- Ask question --}}
                <md-button
                        hide-xs
                        aria-label="@{{ 'KEY_QUESTION' | translate }}"
                        href="/question/create">
                    <span class="green-font-1">
                        <md-icon>
                            <i class="material-icons green-font-1">create</i>
                        </md-icon>
                    @{{ 'KEY_QUESTION' | translate }}
                    </span>
                </md-button>
                @endif

                <md-button
                        hide-xs
                        aria-label="{!! Auth::user()->displayname !!}"
                        href="/profile/{{ Auth::user()->displayname }}">
                    <span class="purple-font">
                        {!! Auth::user()->firstname !!}
                    </span>
                    <img ng-src="{!! Auth::user()->avatar !!}" class="img-circle" width="27px">
                </md-button>

            @else
                {{-- Login button --}}
                <md-button aria-label="Person"
                           ng-href="{{ url('/login') }}"
                           hide-xs>
                    <span class="green-font-1">
                        <md-icon>
                            <i class="material-icons green-font-1">account_circle</i>
                        </md-icon>
                        @{{ 'KEY_LOGIN_REGISTER' | translate }}
                    </span>

                </md-button>

            @endif

        </div>

    </md-toolbar>

    {{-- Main container--}}
    <md-content layout-align="center" style="background: #fafafa">
        @yield('content')
    </md-content>


    {{-- CHANNEL SIDEBAR RIGHT--}}
    <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="right">
        <md-content layout-padding layout="column" layout-align="start">
            {{-- CHANNEL LISTING --}}
            <channels-button></channels-button>
        </md-content>
    </md-sidenav>


    {{-- Sidebar for mobile --}}
    <md-sidenav class="md-sidenav-left md-whiteframe-4dp" md-component-id="left">

        <md-content layout="column" layout-align="start start">

            @if( (Auth::user()) && (Auth::user()->init_setup == 1))

                <md-toolbar layout-align="start start">
                    {{-- Ask question --}}
                    <md-button class="md-hue-1"
                               aria-label="@{{ 'KEY_QUESTION' | translate }}"
                               href="/question/create">
                        <span class="green-font-1">
                            <md-icon>
                                <i class="material-icons green-font-1">create</i>
                            </md-icon>
                            @{{ 'KEY_QUESTION' | translate }}
                        </span>
                    </md-button>
                </md-toolbar>

                {{-- User name and profile --}}
                <md-button
                        class="md-hue-1"
                        aria-label="{!! Auth::user()->displayname !!}"
                        href="/{!! Auth::user()->displayname !!}">
                    {!! Auth::user()->firstname !!}
                    <img ng-src="{!! Auth::user()->avatar !!}" class="img-circle" width="27px">
                </md-button>

            @else

                {{-- Login button --}}
                <md-button class="md-hue-1"
                           aria-label="Person"
                           ng-href="{{ url('/login') }}">
                    <span class="green-font-1">
                        <md-icon>
                            <i class="material-icons green-font-1">account_circle</i>
                        </md-icon>
                        @{{ 'KEY_LOGIN_REGISTER' | translate }}
                    </span>
                </md-button>

            @endif

            {{-- CHANNEL LISTING --}}
            <channels-button></channels-button>

        </md-content>
    </md-sidenav>

</div>


</body>
</html>
