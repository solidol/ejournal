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

<h2>Дисципліни</h2>

<div class="mb-3 mt-1 table-responsive">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    Назва
                </th>
                <th>
                    Оцінки
                </th>
                <th>
                    Пропуски
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->group->journals as $journal)
            <tr>
                <td>
                    {{$journal->subject->title}}
                </td>
                <td>

                </td>

                <td>
                    <a class="btn btn-success pt-0 pb-0" href="#">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

<h2>Відвідував журнал</h2>

<div class="mb-3 mt-1 table-responsive">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    Дата та час
                </th>
                <th>

                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $logItem)
            <tr>
                <td>
                    {{$logItem->created_at}}
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