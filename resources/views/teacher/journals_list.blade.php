@extends('layouts.app-nosidebar')

@section('title', 'Мої дисципліни')
@section('side-title', 'Мої дисципліни')

@section('sidebar')



@stop

@section('content')
<h1>
    Мої дисципліни
    <button type="button" class="mb-1 mt-1 btn btn-danger" data-bs-toggle="modal" data-bs-target="#addLesson">
        Новий журнал
    </button>
</h1>

<div class="mb-3 mt-1 table-responsive">

    <table class="table table-striped table-bordered m-0">
        <thead>
            <tr>
                <th>
                    Група
                </th>
                <th>
                    Назва
                </th>
                <th>
                    Вич.
                </th>
                <th>
                    Відкрити
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            <tr>
                <td>
                    {{$journal->group->nomer_grup}}
                </td>
                <td>
                    {{$journal->subject->subject_name}}
                </td>
                <td>
                    {{$journal->lessons->sum('kol_chasov')}} г.
                </td>
                <td>
                    <a class="btn btn-success pt-0 pb-0" href="{{URL::route('show_journal',['id'=>$journal->id])}}">
                        <i class="bi bi-pencil-square"></i> Переглянути
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>

                </th>
                <th>

                </th>
                <th>

                </th>
                <th>

                </th>
            </tr>
        </tfoot>
    </table>

</div>

@include('popups.new-journal')

@stop