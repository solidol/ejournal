@extends('layouts.app-nosidebar')

@section('title', 'Мої викладачі')




@section('content')
<h1>
    Поточна пара
</h1>


<table class="table table-striped">
    <thead>
        <tr>
            <th>Дисципліна</th>
            <th>Тема</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($lessons as $lesson)
        <tr>
            <td>{{$lesson->journal->title}}</td>
            <td>{{$lesson->tema}}</td>
            <td>
                <a href="{{URL::route('lessons.now.show',['lesson'=>$lesson])}}" class="btn btn-success"><i class="bi bi-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@stop