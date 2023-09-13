@extends('layouts.app')

@section('title', 'Журнал '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')
<div class="baloon">
    <h1>Журнал</h1>

    <h2>Інші журнали</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('journals.edit',['journal'=>$journal])}}">
            <span style="color: <?= $journal->color ?? '#000' ?>;">
            {{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}
            </span>
        </a>
        @endforeach
    </nav>
</div>

@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('lessons.index',['id'=>$currentJournal->id])}}"><i class="bi bi-pencil-square"></i> Записані пари</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('marks.index',['id'=>$currentJournal->id])}}"><i class="bi bi-5-square"></i> Оцінки</a>
</li>
@stop

@section('content')


<h1>Налаштування журналу {{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h1>



<h2>Колір в календарі</h2>
<form action="{{URL::route('journals.update',['journal'=>$currentJournal])}}" method="post">
    @csrf
    <div class="mb-3">
        <input type="color" class="form" name="color" value="{{$currentJournal->color}}">

    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-success">Зберегти</button>
    </div>
</form>

@if ($currentJournal->children()->count()==0)
<h2>Додати поділ</h2>
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addChild">
        <i class="bi bi-clipboard-plus"></i> Створити журнал
    </button>
</div>
@endif
<script type="module">

</script>
@include('journals.popups.create_child')

@include('controls.popups.create')

@include('popups.new-exam-report')

@include('lessons.popups.create')
@stop