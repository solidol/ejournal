<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
                @if (Auth::user()->isTeacher())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('get_journals') }}"><i class="bi bi-book"></i> <span class="d-md-inline d-lg-none">Мої журнали</span></a>
                </li>
                @yield('custom-menu')

                @endif
                @if (Auth::user()->isStudent())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student_get_journals') }}"><i class="bi bi-book"></i> Мої журнали</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-bounding-box"></i> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('show_profile') }}"><i class="bi bi-person-lines-fill"></i> Мій профіль</a>
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
                        @if (Auth::user()->isTeacher())
                        <li>
                            <a class="dropdown-item" href="{{ route('my_timesheet') }}"><i class="bi bi-calendar3-week"></i> Мій табель</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('message_index') }}"><i class="bi bi-envelope-paper"></i> Мої повідомлення</a>
                        </li>
                        @endif
                    </ul>
                </li>

                @if (Auth::user()->isAdmin())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-square"></i> Адміністрування <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_userlist') }}"><i class="bi bi-list-ol"></i> Користувачі</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_another_login') }}"><i class="bi bi-box-arrow-in-right"></i> Увійти як</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_loglist') }}"><i class="bi bi-list-ol"></i> Лог подій</a>
                        </li>
                    </ul>
                </li>
                @endif
                @endif
            </ul>
        </div>
    </div>
</nav>