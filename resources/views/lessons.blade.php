@extends('layouts.app')

@section('title', 'Записані пари')

@section('sidebar')






<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLesson">
    Записати пару
</button>

<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>

</nav>


<h2 class="d-sm-none d-md-block">Записані пари з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">{{$mItem->nomer_grup}} - {{$mItem->subject_name}}</a>
    @endforeach
</nav>

@stop

@section('content')

<h2>{{$data['title1']}}</h2>

<table id="tblessons" class="display table table-striped">
    <thead>
        <tr>

            <th>Дата</th>
            <th>Години</th>
            <th>Тема</th>
            <th>Задано</th>
            <th></th>
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
                {!! nl2br($oItem->tema) !!}
            </td>
            <td>
                {!! nl2br($oItem->zadanaie) !!}
            </td>
            <td>
                <a class="btn btn-primary" href="{{URL::route('show_lesson',['lessonId'=>$oItem->kod_pari])}}"><i class="bi bi-pencil-square"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tblessons').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-success'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success'
                }
            ],
            "paging": false,
            "ordering": false
        });
    });
</script>


@include('popups.new-lesson')
@stop