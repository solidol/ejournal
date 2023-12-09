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

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.journals.index') }}"><i class="bi bi-book"></i> Мої журнали</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.teachers.index') }}"><i class="bi bi-people"></i> Мої викладачі</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.absents.index') }}"><i class="bi bi-person-slash"></i> Мої пропуски</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mdb.index') }}"><i class="bi bi-database"></i> Методична база</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-bounding-box"></i> {{ Auth::user()->userable->fullname }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('my.profile') }}"><i class="bi bi-person-lines-fill"></i> Мій профіль</a>
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

            </ul>
        </div>
    </div>
</nav>