@extends('layouts.app-nosidebar')

@section('title', 'Пара')




@section('content')
<h1>
    {{$lesson->tema}}
</h1>
<div class="fs-2">
    {{$lesson->journal->subject->title}}
</div>
<div class="fs-2">
    {{$lesson->journal->teacher->fullname}}
</div>
@if ($lesson->isPresent(Auth::user()->userable))
<div class="fs-3 my-2 p-2 border border-2 border-danger rounded-2">
    <p class="fs-2 text-danger text-center">
        Ви відмітилися!
    </p>
    <p>
        Подальші дії з вашого боку не потрібні. Після закінчення терміну дії посилання, викладач синхронізує дані.
    </p>
</div>
@else
<form method="post" method="post">
    @csrf
    <div class="fs-3 my-2 p-2 border border-2 border-danger rounded-2">
        <p class="my-2">
            Натисніть кнопку "Відмітитися", щоб зберегти дані про вашу присутність на парі.
        </p>
        <input type="hidden" name="lesson_id" value="{{$lesson->kod_pari}}">
        <button type="submit" class="btn btn-success">Відмітитися</button>
    </div>
</form>
@endif
@stop