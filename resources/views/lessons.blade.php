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
                <i class="bi bi-pencil-square"></i>
            </td>
            <td>
                {{ $oItem->date }}
                <hr width="75%">
                {{ $oItem->kol_chasov }}
            </td>
            
            <td>
                {{ $oItem->tema }}
            </td>
            <td>
                {{ $oItem->zadanaie }}
            </td>
            <td>
                <a class="text-danger" href="{{URL::route('delete_lesson',['lessId'=>$oItem->kod_pari])}}" data-confirm="Видалити?"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>




@include('popups.new-lessons')
@stop