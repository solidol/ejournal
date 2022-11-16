@extends('layouts.app')

@section('title', 'Записана пара')

@section('sidebar')
<h2>Навігація</h2>
<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$data['subj'],'group'=>$data['group']])}}">До журналу</a>

</nav>
@stop

@section('content')

<h2>{{$data['title1']}} <a class="text-primary" href="#"  data-bs-toggle="modal" data-bs-target="#editLesson"><i class="bi bi-pencil-square"></i></a></h2>

<h3>{{$lesson->dateFormatted}} {{$lesson->tema}}</h3>

<p>{{$lesson->zadanaie}}</p>

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
                {{$absItem->nom_pari}}
            </td>
        </tr>
        @endforeach
    </tbody>
</tabel>

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