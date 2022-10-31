@extends('layouts.app')

@section('title', 'Записані пари')

@section('sidebar')






<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Записати пару
</button>

<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects',['prep'=>$data['prep']])}}">Ha головну</a>

</nav>


<h2 class="d-sm-none d-md-block">Записані пари з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_lessons',['prep'=>$data['prep'],'subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">{{$mItem->nomer_grup}} - {{$mItem->subject_name}}</a>
    @endforeach
</nav>

@stop

@section('content')

<h2>{{$data['title1']}}</h2>

<table id="example" class="display table table-striped">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Години</th>
            <th>Тема</th>
            <th>Що задано</th>
            <th>Видалити</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($oList as $key=>$oItem)
        <tr>
            <td>
                {{ $oItem->date }}
            </td>
            <td>
                {{ $oItem->kol_chasov }}
            </td>
            <td>
                {{ $oItem->tema }}
            </td>
            <td>
                {{ $oItem->zadanaie }}
            </td>
            <td>
                <a class="btn btn-danger" href="{{URL::route('delete_lesson',['lessId'=>$oItem->kod_pari])}}"  data-confirm="Видалити?"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>




<!-- Modal -->
<form action="{{$storeRoute}}" method="post">
@csrf <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Записати пару</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="grcode" value="{{$data['group']}}">
                    <input type="hidden" name="sbjcode" value="{{$data['subj']}}">

                    <div class="mb-3">
                        <label for="datetime1" class="form-label">Дата</label>
                        <input type="date" class="form-control" id="datetime1" name="datetime">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Номер пари</label>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio1" value="1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">1</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio2" value="2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">2</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio3" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio3">3</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio4" value="4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio4">4</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio5" value="5" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio5">5</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio6" value="6" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio6">6</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio7" value="7" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio7">7</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio8" value="8" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio8">8</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Годин</label>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="hours" id="btnradio11" value="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio11">1</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio12" value="2" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio12">2</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio13" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio13">3</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio14" value="4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio14">4</label>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="thesis" class="form-label">Тема</label>
                        <input type="text" class="form-control" id="thesis" name="thesis">
                    </div>
                    <div class="mb-3">
                        <label for="zadanaie">Що задано</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="homework" name="homework"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
//document.getElementById('datetime').valueAsDate = new Date();



$(document).ready(function () {
    
    $('#datetime1').val(new Date().toISOString().split('T')[0]);
    //$('#example').DataTable();
});
</script>
@stop