@extends('layouts.app')

@section('title', 'Журнал дисципліни')

@section('sidebar')



@stop

@section('content')
<h2></h2>
<ul>

    <li>
    <a href="{{URL::route('get_lessons',['prep'=>$data['prep'],'subj'=>$data['subj'],'group'=>$data['group']])}}">
            Записати/переглянути пару
        </a>
    </li>
    <li>
        <a href="{{URL::route('get_marks',['prep'=>$data['prep'],'subj'=>$data['subj'],'group'=>$data['group']])}}">
            Записати/переглянути оцінки
        </a>
    </li>



</ul>


@stop