                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-square"></i> Адміністрування <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_userlist',['slug'=>'teachers']) }}"><i class="bi bi-list-ol"></i> Викладачі</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_userlist',['slug'=>'students']) }}"><i class="bi bi-list-ol"></i> Студенти</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_loglist') }}"><i class="bi bi-list-ol"></i> Лог подій</a>
                        </li>
                    </ul>
                </li>