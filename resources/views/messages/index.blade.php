@extends('layouts.app-nosidebar')

@section('title', 'Мої повідомлення')


@section('content')
<h1>Мої повідомлення</h1>


<h2>
    <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#shareLesson"><i class="bi bi-envelope-paper"></i> Створити</a>
    Текстові
</h2>
<table class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>
                Дата
            </th>
            <th>
                Від
            </th>
            <th>
                Зміст
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($messages as $mes)
        <tr>
            <td>
                {{$mes->datetime_start->format('d.m.Y H:i')}}
            </td>
            <td>
                {{$mes->from_id>0?$mes->user->userable->FIO_prep:'Адміністратор'}}
            </td>
            <td>
                {!! nl2br($mes->content) !!}
            </td>
            <td>
                @if ($mes->from_id>0)
                <a href="{{URL::route('messages.delete',['message'=>$mes])}}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>





@include('messages.popups.create')

@stop