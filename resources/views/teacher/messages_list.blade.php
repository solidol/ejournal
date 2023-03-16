@extends('layouts.app-nosidebar')

@section('title', 'Мої повідомлення')
@section('sidebar')

<div class="baloon">
    <h1>Мої повідомлення</h1>
</div>

@stop

@section('content')
<h1>Мої повідомлення</h1>


<h2>Поширені пари</h2>
<table class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>
                Від
            </th>
            <th>
                Група
            </th>
            <th>
                Дисципліна
            </th>
            <th>
                Дата
            </th>
            <th>
                Тема
            </th>
            <th>
                Дія
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($arLessons as $lesson)
        <tr>
            <td>
                {{$lesson->user->userable->FIO_prep}}
            </td>
            <td>
                {{$lesson->content->group}}
            </td>
            <td>
                {{$lesson->content->subject->subject_name}}
            </td>
            <td>
                {{$lesson->content->data_->format('d.m.y')}} p.
            </td>
            <td>
                {{$lesson->content->tema}}
            </td>
            <td>
                <a class="btn btn-success" disabled="disabled" href="{{URL::route('message_accept_lesson',['messId'=>$lesson->id])}}">
                    Погодити
                </a>
                <a class="btn btn-danger" disabled="disabled" href="{{URL::route('message_delete',['messId'=>$lesson->id])}}">
                    Відхилити
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

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
                <a class="btn btn-danger" href="{{URL::route('message_delete',['messId'=>$text->id])}}">
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



@include('popups.new-message')

@stop