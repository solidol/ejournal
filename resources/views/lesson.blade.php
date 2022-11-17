@extends('layouts.app')

@section('title', 'Записана пара')

@section('sidebar')
<h2>Навігація</h2>
<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$data['subj'],'group'=>$data['group']])}}">До журналу</a>

</nav>
@stop

@section('content')

<h2>{{$data['title1']}} </h2>

<h3>
    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#editLesson"><i class="bi bi-pencil-square"></i> Редагувати</a>
    {{$lesson->dateFormatted}} {{$lesson->tema}}
</h3>

<p>{{$lesson->zadanaie}}</p>



<div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed bg-dblue text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Додатково
            </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body"> <a class="btn btn-danger" href="{{URL::route('delete_lesson',['lessonId'=>$lesson->kod_pari])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i> Видалити</a></div>
        </div>
    </div>

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
                {{$absItem->nom_pari?'нб':''}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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

    });
</script>


@include('popups.edit-lesson')

@stop