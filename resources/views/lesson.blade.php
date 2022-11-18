@extends('layouts.app')

@section('title', 'Записана пара')

@section('sidebar')

<button type="button" id="btnAddControl" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addControl">
    Додати контроль
</button>

<h2>Навігація</h2>
<nav class="nav flex-column">
    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>
    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$data['subj'],'group'=>$data['group']])}}">Всі пари дисципліни</a>

</nav>
@stop

@section('content')

<h2>{{$data['title1']}} </h2>

<h3 class="bg-light-grey">
    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#editLesson"><i class="bi bi-pencil-square"></i> Редагувати</a>
    {{$lesson->dateFormatted}} {{$lesson->tema}}
</h3>

<h4>{{$lesson->zadanaie}}</h4>

<h3>Контролі сьогодні</h3>
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
        <tr>
            @foreach ($arCtrls as $ctrlItem)
            <td>
                {{$ctrlItem->vid_kontrol}}
            </td>
            <td>
                {{$ctrlItem->ocenka}}
            </td>
            <td>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Відсутні</h3>

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
                <input type="text" class="form form-control" name="abs[{{$absItem->kod_stud}}_{{$absItem->lesson_id}}]" value="{{$absItem->nom_pari?'нб':''}}" placeholder="">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-danger">Видалення записаної пари</h3>
<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <div class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed bg-dblue text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Натиснути для видалення
            </button>
        </div>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body"> <a class="btn btn-danger" href="{{URL::route('delete_lesson',['lessonId'=>$lesson->kod_pari])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i> Видалити</a></div>
        </div>
    </div>

</div>



<script>
    //document.getElementById('datetime').valueAsDate = new Date();



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
        //$('#datetime1').val(new Date().toISOString().split('T')[0]);
        $('#btnAddControl').click(function() {
            $('#datetimeAddControl').val('{{$lesson->data_}}');
        });
    });
</script>


@include('popups.edit-lesson')

@include('popups.new-control')

@stop