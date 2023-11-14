@extends('layouts.app-nosidebar')

@section('title', 'Пара')




@section('content')
<h1>
    Генератор фейкових даних
</h1>
<h2>Абзац</h2>
<div class="fs-3">
    {{$text}}
</div>

<h2>Слово</h2>
<div class="fs-3">
    {{$word}}
</div>

<h2>Речення</h2>
<div class="fs-3">
    {{$sentence}}
</div>

@stop