@extends('layouts.app-nosidebar')

@section('title', 'Пара')




@section('content')
<h1>
    Поточна пара
</h1>
<div class="fs-2">
    {{$lesson->journal->subject->title}}
</div>
<div class="fs-2">
    {{$lesson->journal->teacher->fullname}}
</div>
<div class="fs-2">
    {{$lesson->tema}}
</div>

<form method="post">
    @csrf
    <input type="hidden" name="lesson_id" value="{{$lesson->kod_pari}}">
    <button type="submit" class="btn btn-success">Відмітитися</button>
</form>

@stop