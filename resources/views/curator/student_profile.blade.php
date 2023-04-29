@extends('layouts.app-nosidebar')

@section('title', 'Студенти')
@section('side-title', 'Студенти')

@section('sidebar')



@stop

@section('content')
<h1>
    Профіль студента {{$student->FIO_stud}} групи {{$student->group->nomer_grup}}
</h1>

<h2>Логін {{ $student->user->name }}</h2>

<h2>Відвідував журнал</h2>

<div class="mb-3 mt-1 table-responsive">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    Дата та час
                </th>
                <th>
                    Додаткова інформація
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $logItem)
            <tr>
                <td>
                    {{$logItem->created_at->format('d.m.Y H:i')}}
                </td>
                <td>
                    {{$logItem->comment}}
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@stop