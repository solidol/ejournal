@extends('layouts.app')

@section('title', 'Журнал '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')
<div class="baloon">
    <h1>Журнал</h1>

    <h2>Інші журнали</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('show_journal',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
        @endforeach
    </nav>
</div>

@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('list_lessons',['id'=>$currentJournal->id])}}"><i class="bi bi-pencil-square"></i> Записані пари</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('get_marks',['id'=>$currentJournal->id])}}"><i class="bi bi-5-square"></i> Оцінки</a>
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



<script type="module">

</script>
@include('popups.new-control')

@include('popups.new-exam-report')

@include('popups.new-lesson')
@stop