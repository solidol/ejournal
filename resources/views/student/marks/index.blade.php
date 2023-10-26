@extends('layouts.app')

@section('title', 'Оцінки '. Auth::user()->name)
@section('side-title', 'Оцінки')

@section('sidebar')

<div class="baloon">
    <h2>Оцінки з інших дисциплін</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        @if ($journal->controls->count() > 0)
        <a class="nav-link" href="{{URL::route('student_get_marks',['id'=>$journal->id])}}">{{$journal->subject->subject_name}}</a>
        @endif
        @endforeach
    </nav>
</div>

@stop


@section('content')


@if (!$currentJournal)
<h2>Оцінки. Оберіть журнал</h2>
@else
<div class="row m-3">
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <img class="w-75" src="{{route('teacher.avatar.get',['id'=>$currentJournal->teacher->id])}}">
    </div>
    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-xs-12">
        <h2>{{$currentJournal->subject->subject_name}}</h2>
        <p class="fs-3">Викладач - {{$currentJournal->teacher->FIO_prep}}</p>
        <ul>
            <li>
                Н/А, н/а, НА, на - неатестований
            </li>
            <li>
                Зар, зар, З, з - зараховано
            </li>
        </ul>
    </div>
</div>

<h3>Контролі</h3>
<table id="tdctrl" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Контроль</th>
            <th>Оцінка</th>
        </tr>
    </thead>
    <tbody>
        @foreach($currentJournal->controls as $control)
        @if ($control->title)
        <tr>
            <td>
                {{$control->date_->format('d.m.Y')??'Дата не вказана'}}
            </td>
            <td>
                {{$control->title}}
            </td>
            <td>
                <b class="mark-in-list">{{$control->mark(Auth::user()->userable_id)->mark_str??'-'}}</b><span>з {{$control->max_grade}} б.</span>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

@if($currentJournal->hasPractices())
<h3>Лабораторні</h3>
<table id="tdpr" class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Назва</th>
            <th>Оцінка</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($currentJournal->practices as $control)
        @if ($control->title)
        <tr>
            <td>
                {{$control->date_->format('d.m.Y')??'Дата не вказана'}}
            </td>
            <td>
                {{$control->title}}
            </td>
            <td>
                <b class="mark-in-list">{{$control->mark(Auth::user()->userable_id)->mark_str??'-'}}</b><span>з {{$control->max_grade_str}}.</span>
            </td>
            <td>
                <a href="{{URL::route('student.practices.show',['practice'=>$control])}}" class="btn btn-success"><i class="bi bi-exclamation-triangle"></i></a>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endif
@endif



<script type="module">
    $(document).ready(function() {

        $('#dtctrl,#dtpr').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary'
            }],
            paging: false,
            ordering: false,
            searching: false,
            columnDefs: [{
                target: 0,
                visible: false,
            }],
        });


    });
</script>



@stop