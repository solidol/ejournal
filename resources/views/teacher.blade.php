@extends('layouts.app')

@section('title', 'Мої дисципліни')

@section('sidebar')



@stop

@section('content')

<!--

<table class="table table-striped">
    <thead>
        <tr>
            <th>
                Група
            </th>
            <th>
                Дисціпліна
            </th>
            <th>
                Пари
            </th>
            <th>
                Оцінки
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach($mList as $mItem)
        <tr>
            <td>
                {{$mItem->nomer_grup}}
            </td>
            <td>
                {{$mItem->subject_name}}
            </td>
            <td>
                <a href="{{URL::route('get_lessons',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">
                    Пари
                </a>
            </td>
            <td>
                <a href="{{URL::route('get_marks',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">
                    Оцінки
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
-->

<div class="row row-cols-1 row-cols-xl-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 g-4 card-row">

    @foreach($mList as $mItem)
    <div class="col">
        <div class="card h-100">
            <div class="card-header text-white bg-dblue">
                <h3>{{$mItem->nomer_grup}}</h3>
            </div>
            <div class="card-body">
                <p>{{$mItem->subject_name}}</p>
            </div>
            <div class="card-footer">
                <a class="btn btn-success" href="{{URL::route('get_lessons',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">
                    Пари
                </a>
                <a class="btn btn-primary" href="{{URL::route('get_marks',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">
                    Оцінки
                </a>
                <a class="btn btn-secondary" href="#">
                    Відсутні
                </a>
            </div>
        </div>
    </div>
    @endforeach

</div>

@stop