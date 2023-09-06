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

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('journals.index') }}"><i class="bi bi-book"></i> <span class="d-md-inline d-lg-none">Журнали</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('find_student') }}"><i class="bi bi-search"></i> <span class="d-md-inline d-lg-none">Пошук студента</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('get_method_index') }}"><i class="bi bi-database"></i> <span class="d-md-inline d-lg-none">Електронна база</span></a>
                </li>
                @if (Auth::user()->isDPScriber())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('diploma_projectings_index') }}">ДП</a>
                </li>
                @endif

                @yield('custom-menu')

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-bounding-box"></i> {{ Auth::user()->userable->fullname }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('show_profile') }}"><i class="bi bi-person-lines-fill"></i> Мій профіль</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('my.timesheet') }}"><i class="bi bi-calendar3-week"></i> Мій табель</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('my.calendar') }}"><i class="bi bi-calendar3-week"></i> Мій календар</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('message_index') }}"><i class="bi bi-envelope-paper"></i> Мої повідомлення</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
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

                @if (Auth::user()->isCurator())
                <li class="nav-item">
                    <a class="nav-link" href="/curator" class="btn btn-outline-success"><i class="bi bi-pencil-square"></i> Журнали куратора</a>
                </li>
                @endif


                @if (Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="/admin" class="btn btn-outline-success"><i class="bi bi-gear"></i> <span class="d-md-inline d-lg-none">Адмінпанель</span></a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>