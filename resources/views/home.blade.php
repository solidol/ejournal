@extends('layouts.app-simple')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header  text-white bg-dark">Вхід у журнал</div>

                <div class="card-body">
                    <h1>Ви виконали вхід в журнал</h1>
                    <p>Вітаємо, {{Auth::user()->name}}!</p>
                    @if (Auth::user()->isTeacher())
                    <p>Перейдіть до ваших журналів в головному меню - <a class="btn btn-outline-primary" href="{{ route('get_journals') }}"><i class="bi bi-book"></i></a>
                    </p>
                    @endif
                    @if (Auth::user()->isStudent())
                    <p>Перейдіть до ваших журналів в головному меню - <a class="btn btn-outline-primary" href="{{ route('student_get_journals') }}"><i class="bi bi-book"></i></a>
                    </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @endsection