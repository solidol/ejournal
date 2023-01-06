<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <!--<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>-->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/datatables.min.js"></script>
    <script src="/assets/js/datatables.buttons.min.js"></script>
    <script src="/assets/js/jszip.min.js"></script>
    <script src="/assets/js/buttons.html5.min.js"></script>

    <script src="/assets/js/confirmbutton.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <!--    <link rel="stylesheet" href="/assets/css/buttons.datatables.min.css">-->

    <link href="/assets/css/app.css" rel="stylesheet">

</head>

<body>



    <div id="app">

        @include('menus.mainmenu')

        <div class="container-fluid">

            @if (Auth::user())

            <div class="row">
                <aside class="col-lg-3 col-md-5 col-sm-12 col-xs-12">
                    <h1>@yield('side-title')</h1>
                    @yield('sidebar')
                </aside>
                <main class="col-lg-9 col-md-7 col-sm-12 col-xs-12">

                    @yield('content')
                </main>
            </div>
            @else
            <main>

                @yield('content')
            </main>
            @endif
        </div>
    </div>
    <script>

    </script>
</body>

</html>