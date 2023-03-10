@extends('layouts.app-simple')

@section('title', 'Електронний журнал')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-header text-white bg-dark">Вхід у журнал</div>

                <div class="card-body">
                    <div style="text-align: center;">
                        <h1>Електронний журнал ХПФК</h1>
                        <p>Необхідна авторизація!</p>
                        <p><a href="{{ route('login') }}" class="btn btn-primary">Увійти</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@stop