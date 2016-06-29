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

<body>

@yield('content')


</body>
</html>
