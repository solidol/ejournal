@extends('layouts.app')

@section('title', 'Журнал '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')
<div class="baloon">
    <h1>Журнал</h1>

    <h2>Інші журнали</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('journals.show',['journal'=>$journal])}}">
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


<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>
<p>Класний керівник - {{$currentJournal->group->curator->FIO_prep}}</p>

<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
        <i class="bi bi-pencil"></i> Записати пару
    </button>
</div>
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addControl">
        <i class="bi bi-5-square"></i> Додати контрль
    </button>
</div>
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamReport">
        <i class="bi bi-clipboard-plus"></i> Додати відомість
    </button>
</div>

<h2>Налаштування</h2>
<div class="p-2 border border-2 border-primary rounded-2">
    <a href="{{URL::route('journals.edit',['journal'=>$currentJournal])}}" class="btn btn-danger fs-3"><i class="bi bi-gear"></i> Налаштування</a>
</div>

<script type="module">

</script>
@include('controls.popups.create')

@include('popups.new-exam-report')

@include('lessons.popups.create')
@stop