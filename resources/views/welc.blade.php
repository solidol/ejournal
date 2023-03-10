@extends('layouts.app-simple')

@section('title', 'Електронний журнал')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header text-white bg-dark">Вхід у журнал</div>

                <div class="card-body">
                    <div style="text-align: center;">
                        <h1>Електронний журнал</h1>
                        <h2>Необхідна авторизація!</h2>
                        <h2><a href="{{ route('login') }}" class="btn btn-primary">Увійти</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@stop