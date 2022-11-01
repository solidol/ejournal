@extends('layouts.app')

@section('title', 'Мої дисципліни')

@section('sidebar')



@stop

@section('content')


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

@stop