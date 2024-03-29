@extends('layouts.app')

@section('title', 'Записана пара '. $lesson->data_->format('d.m.y') . ' '. $lesson->tema)


@section('sidebar')
<div class="baloon">
    <h1>Записана пара</h1>
    <div class="mb-3 mt-3">
        <button type="button" id="btnAddControl" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addControl">
            Додати контроль
        </button>
    </div>
    <div class="mb-3 mt-3">
        <button type="button" id="btnAddPractice" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPractice">
            Додати лабораторну
        </button>
    </div>
</div>

<div class="baloon d-none d-md-block">
    <h2>Інші пари дисципліни</h2>
    <nav class="nav flex-column">
        @foreach($currentJournal->lessons as $lessonItem)
        <a class="nav-link" href="{{URL::route('lessons.show',['lesson'=>$lessonItem])}}">{{$lessonItem->data_->format('d.m')}} - {{$lessonItem->tema}}</a>
        @endforeach
    </nav>
</div>
@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addControl"><i class="bi bi-pencil-square"></i> Додати контроль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addPractice"><i class="bi bi-pencil-square"></i> Додати лабу</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('marks.index',['id'=>$currentJournal->id])}}"><i class="bi bi-5-square"></i> Оцінки</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('practices.index',['id'=>$currentJournal->id])}}"><i class="bi bi-clipboard2-pulse"></i> лабораторні</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('lessons.index',['id'=>$lesson->journal->id])}}"><i class="bi bi-list-columns"></i> Пари дисципліни</a>
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
        <table id="tab-absent" class="table table-striped m-0">
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
                        <a class="btn btn-success pt-0 pb-0" href="{{URL::route('marks.index',['id'=>$control->journal_id])}}">
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
        <p>
            Будь-яка позначка або подвійний клік для відмітки. Обов'язково натисніть "Зберегти"
        </p>
        <p>
            Посилання для відмічання студентів:
        </p>
        <p>
            <input type="text" id="studUrl" value="{{$lesson->student_url}}" readonly>
            <button type="button" id="copyUrl" data-url="{{$lesson->student_url}}" class="btn btn-success">
                <i class="bi bi-copy"></i> Натисніть для копіювання
            </button>
        </p>
        <form id="formabsents" action="{{URL::route('absents.store',['id'=>$lesson->id])}}" method="post">
            @csrf
            <div class="my-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-clipboard-plus"></i> Зберегти
                </button>
                <button type="button" class="websync btn btn-primary">
                    Синхронізувати з web
                </button>
                <button type="button" class="clear btn btn-danger">
                    Очистити НБ
                </button>
            </div>

            <table id="tab-absent" class="table table-striped m-0">
                <thead>
                    <tr>
                        <th>
                            ПІБ студента
                        </th>
                        <th>
                            Відсутній
                        </th>
                        <th>
                            <div>
                            Web-відмітка
                            </div>
                            <div>
                                {{$lesson->presents->count()}}/{{$lesson->group->students->count()}}
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($lesson->group->students as $student)
                        <td>
                            {{$student->fullname}}
                        </td>
                        <td>
                            <input type="text" class="inp-abs form form-control" name="abs[{{$student->id}}]" value="{{$lesson->absent($student->id)?'нб':''}}" data-webabsent="{{$lesson->present($student->id)?'':'нб'}}" placeholder="">
                        </td>
                        <td>
                            {{$lesson->present($student->id)?'так':''}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-3">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-clipboard-plus"></i> Зберегти
                </button>
                <button type="button" class="websync btn btn-primary">
                    Синхронізувати з web
                </button>
                <button type="button" class="clear btn btn-danger">
                    Очистити НБ
                </button>
            </div>
        </form>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="p-2 border border-2 border-primary rounded-2">
            <h3 class="text-danger">Редагування та поширення</h3>
            <div class="mb-2 mt-2">
                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#editLesson"><i class="bi bi-pencil-square"></i> Редагувати</a>
            </div>
            <div class="mb-2 mt-2">
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
                        <div class="accordion-body"> <a class="btn btn-danger" href="{{URL::route('lessons.delete',['lesson'=>$lesson])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i> Видалити</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script type="module">
    $(document).ready(function() {
        $('#copyUrl').click(function() {
            let copyText = document.querySelector("#studUrl");
            copyText.focus();
            copyText.select();
            document.execCommand("copy");
        });
        $('.websync').click(function() {
            $('.inp-abs').each(function(index, item) {
                $(item).val($(item).data('webabsent'));
            });
            //if (confirm('Зберегти зміни одразу після синхронізації?'))
            //    $('#formabsents').submit();
        });
        $('.clear').click(function() {
            if (confirm('Точно очистити всі НБ?'))
                $('.inp-abs').val('');
        });
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


@include('lessons.popups.edit')

@include('controls.popups.create')

@include('practices.popups.create')

@stop