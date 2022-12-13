@extends('layouts.app')

@section('title', 'Електронний журнал')

@section('sidebar')



@stop

@section('content')
<div style="text-align: center;">
    <h1>Електронний журнал</h1>
    <h2>Необхідна авторизація!</h2>
    <h2><a href="{{ route('login') }}" class="btn btn-primary">Увійти</a></h2>
</div>
@stop