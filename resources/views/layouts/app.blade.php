<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>


    <script src="/assets/js/confirmbutton.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.preloader')

    <div id="app">
        @include('menus.mainmenu')
        <div class="container-fluid">

            @if (Auth::user())

            <div class="row">
                <div class="col-lg-3 col-md-5 col-sm-12 col-xs-12">
                    <aside>
                        @yield('sidebar')
                    </aside>
                </div>
                <div class="col-lg-9 col-md-7 col-sm-12 col-xs-12">
                    <main class="baloon">
                        @yield('content')
                    </main>
                </div>
            </div>
            @else
            <main>

                @yield('content')
            </main>
            @endif
        </div>
    </div>
    @include('popups.popup-messages')

</body>

</html>