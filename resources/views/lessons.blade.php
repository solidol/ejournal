@extends('layouts.app')

@section('title', 'Записані пари')

@section('sidebar')






<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
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

<table id="example" class="display table table-striped">
    <thead>
        <tr>
            <th></th>
            <th>Дата Години</th>

            <th>Тема</th>
            <th>Задано</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($oList as $key=>$oItem)
        <tr>
            <td>
                <a class="text-primary" href="{{URL::route('edit_lesson',['lessId'=>$oItem->kod_pari])}}"><i class="bi bi-pencil-square"></i></a>
            </td>
            <td>
                {{ $oItem->date }}
                <hr width="75%">
                {{ $oItem->kol_chasov }}
            </td>

            <td>
                {!! nl2br($oItem->tema) !!}
            </td>
            <td>
                {!! nl2br($oItem->zadanaie) !!}
            </td>
            <td>
                <a class="text-danger" href="{{URL::route('delete_lesson',['lessId'=>$oItem->kod_pari])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>




@include('popups.new-lesson')
@stop