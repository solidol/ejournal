<nav class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top">
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

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-book"></i> Моя група
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('curator_get_journals') }}"><i class="bi bi-person-lines-fill"></i> Оцінки у моїх групаї</a>
                        </li>
                        <!--
                        <li>
                            <a class="dropdown-item" href="{{ route('curator_get_journals') }}"><i class="bi bi-person-slash"></i> Відсутні</a>
                        </li>
-->
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/teacher" class="btn btn-outline-success"><i class="bi bi-book"></i> Загальний журнал</a>
                </li>

            </ul>
        </div>
    </div>
</nav>