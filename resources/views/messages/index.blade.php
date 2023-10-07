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
                Від
            </th>
            <th>
                Зміст
            </th>
            <th>
                Дія
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($arTexts as $text)
        <tr>
            <td>
                {{$text->user->userable->FIO_prep}}
            </td>
            <td>
                {!! nl2br($text->content) !!}
            </td>

            <td>
                <a class="btn btn-danger" href="{{URL::route('messages.delete',['message'=>$text->id])}}">
                    Видалити
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

<h2>
    Системні
</h2>
<table class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>
                Від
            </th>
            <th>
                Зміст
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($arSystem as $text)
        <tr>
            <td>
                {{$text->user->userable->FIO_prep}}
            </td>
            <td>
                {!! nl2br($text->content) !!}
            </td>
        </tr>
        @endforeach
    </tbody>

</table>



@include('messages.popups.create')

@stop