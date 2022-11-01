@extends('layouts.app')

@section('title', 'Записані пари')

@section('sidebar')
<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>

</nav>
@stop


@section('content')

<h2>{{$data['title1']}}</h2>
<form action="{{$storeRoute}}" method="post">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Редагувати пару</h5>

        </div>
        <div class="modal-body">

            <input type="hidden" name="lesscode" value="{{$lesson->kod_pari}}">
            <input type="hidden" name="grcode" value="{{$lesson->kod_grupi}}">
            <input type="hidden" name="sbjcode" value="{{$lesson->kod_subj}}">

            <div class="mb-3">
                <label for="datetime1" class="form-label">Дата</label>
                <input type="date" class="form-control" id="datetime1" name="datetime" value="{{$lesson->data_}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Номер пари</label>
                <input type="number" class="form-control" id="lessnom" name="lessnom" value="{{$lesson->nom_pari}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Години</label>
                <input type="number" class="form-control" id="hours" name="hours" value="{{$lesson->kol_chasov}}">
            </div>
            <div class="mb-3">
                <label for="thesis" class="form-label">Тема</label>
                <textarea class="form-control" placeholder="Leave a comment here" id="thesis" name="thesis">{{$lesson->tema}}</textarea>
            </div>
            <div class="mb-3">
                <label for="zadanaie">Що задано</label>
                <textarea class="form-control" placeholder="Leave a comment here" id="homework" name="homework">{{$lesson->zadanaie}}</textarea>
                <button id="addlect" type="button" class="btn btn-secondary">Конспект</button>
                <button id="addrep" type="button" class="btn btn-secondary">Звіт</button>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Зберегти</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
            <button type="button" class="btn btn-danger" id="freset">Очистити</button>

        </div>
    </div>
</form>
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
@stop