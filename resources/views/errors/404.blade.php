@extends('layouts.app-simple')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header  text-white bg-dark">Щось не так</div>

                    <div class="card-body">
                        <h1>Помилка 404</h1>
                        <p>
                            Сторінку не знайдено!
                        </p>
                        <p>
                            {{ date('d.m.Y H:i:s') }}
                        </p>
                        <p>
                            {{ date_default_timezone_get() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
