@extends('layouts.app')

@section('title', 'Не знайдено')
@section('side-title', 'Не знайдено')

@section('sidebar')
<h2>Навігація</h2>
<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>

</nav>

@stop

@section('content')


<h2>Елемент не знайдено</h2>

@stop