@extends('layouts.app')

@section('title', 'Записана пара '. $lesson->data_->format('d.m.y') . ' '. $lesson->tema)
@section('side-title', 'Записана пара')

@section('sidebar')
<div class="mb-3 mt-3">
    <button type="button" id="btnAddControl" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addControl">
        Додати контроль
    </button>
</div>

<h2>Інші пари дисципліни</h2>
<nav class="nav flex-column d-none d-md-block">
    @foreach($currentJournal->lessons as $lessonItem)
    <a class="nav-link" href="{{route('show_lesson',['id'=>$lessonItem->kod_pari])}}">{{$lessonItem->data_->format('d.m')}} - {{$lessonItem->tema}}</a>
    @endforeach
</nav>
@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addControl"><i class="bi bi-pencil-square"></i> Додати контроль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('show_journal',['id'=>$lesson->journal->id])}}"><i class="bi bi-list-columns"></i> Пари дисципліни</a>
</li>
@stop

@section('content')

<h2>{{$lesson->journal->group->nomer_grup}} {{$lesson->journal->subject->subject_name}} </h2>

<h2>{{$lesson->data_->format('d.m.y')}} {{$lesson->tema}}</h2>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <h3>Задано:</h3>
        <p>{{$lesson->zadanaie}}</p>

        <h3>Контролі сьогодні</h3>
        @if ($lesson->hasControl())
        <table id="tab-absent" class="table table-striped">
            <thead>
                <tr>
                    <th>
                        Назва
                    </th>
                    <th>
                        Макс
                    </th>
                    <th>

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lesson->controls() as $control)
                <tr>
                    <td>
                        {{$control->title}}
                    </td>
                    <td>
                        {{$control->max_grade}}
                    </td>
                    <td>
                        <a class="btn btn-success pt-0 pb-0" href="{{URL::route('get_marks',['id'=>$control->journal_id])}}">
                            <i class="bi bi-pencil-square"></i> Переглянути
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="bg-light-grey">Немає контролів в цей день</p>
        @endif

        <h3>Відсутні</h3>
        <p>Будь-яка позначка або подвійний клік для відмітки. Обов'язково натисніть "Зберегти"</p>
        <form action="{{URL::route('store_absents')}}" method="post">
            @csrf
            <input type="hidden" name="lessonid" value="{{$lesson->kod_pari}}">
            <input type="hidden" name="date" value="{{$lesson->data_}}">
            <input type="hidden" name="less_nom" value="{{$lesson->nom_pari}}">
            <input type="hidden" name="group" value="{{$lesson->kod_grupi}}">
            <input type="hidden" name="prep" value="{{$lesson->kod_prep}}">
            <input type="hidden" name="subj" value="{{$lesson->kod_subj}}">

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-clipboard-plus"></i> Зберегти
                </button>
            </div>

            <table id="tab-absent" class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            ПІБ студента
                        </th>
                        <th>
                            Відсутній
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($arAbsent as $absItem)
                        <td>
                            {{$absItem->FIO_stud}}
                        </td>
                        <td>
                            <input type="text" class="inp-abs form form-control" name="abs[{{$absItem->kod_stud}}]" value="{{$absItem->absents->where('kod_lesson',$lesson->kod_pari)->first()?'нб':''}}" placeholder="">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-clipboard-plus"></i> Зберегти
                </button>
            </div>
        </form>
    </div>
    <div class="col-lg-4 col-md-12">
        <h3 class="text-danger">Редагування та поширення</h3>
        <div class="mb-2 mt-2">
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#editLesson"><i class="bi bi-pencil-square"></i> Редагувати</a>
        </div>
        <div class="mb-2 mt-2">
            <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#shareLesson"><i class="bi bi-share-fill"></i> Поширити</a>
        </div>
        <h3 class="text-danger">Видалення записаної пари</h3>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Натиснути для видалення
                    </button>
                </div>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body"> <a class="btn btn-danger" href="{{URL::route('delete_lesson',['id'=>$lesson->id])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i> Видалити</a></div>
                </div>
            </div>

        </div>
    </div>
</div>




@include('popups.new-control')

<script type="module">
    $(document).ready(function() {
        $('#freset').click(function() {
            $('#homework').val('');
            $('#thesis').val('');
        });
        $('#addlect').click(function() {
            $('#homework').val('Конспект');
        });
        $('#addrep').click(function() {
            $('#homework').val('Звіт');
        });
        $('#btnAddControl').click(function() {
            $('#datetimeAddControl').val('{{$lesson->data_}}');
        });
        $('.inp-abs').dblclick(function() {
            if ($(this).val() == '')
                $(this).val('нб')
            else
                $(this).val('')
        });
    });
</script>


@include('popups.edit-lesson')

@include('popups.share-lesson')

@include('popups.new-control')

@stop