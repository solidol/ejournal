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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <script src="/assets/js/confirmbutton.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/assets/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />


</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dblue fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/assets/img/logo.png"> {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Увійти</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @endguest
                        @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('get_subjects') }}"><i class="bi bi-book"></i> Мої журнали</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-bounding-box"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('show_profile') }}"><i class="bi bi-person-lines-fill"></i> Мій профіль</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('my_table') }}"><i class="bi bi-calendar3-week"></i> Мій табель</a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Вихід
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>

                            </ul>
                        </li>
                        @if (Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-square"></i> Адміністрування <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">

                                @if (Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin_userlist') }}"><i class="bi bi-list-ol"></i> Користувачі</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin_another_login') }}"><i class="bi bi-box-arrow-in-right"></i> Увійти як</a>
                                </li>
                                @endif


                            </ul>
                        </li>
                        @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">

            @if (Auth::user())

            <div class="row">

                <main class="col-12">

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
</body>

</html>