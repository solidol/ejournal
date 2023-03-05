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

<div class="mb-3 mt-1 row row-cols-1 row-cols-xl-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 g-4 card-row">

    <table class="table table-striped table-bordered">
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
                    {{$journal->lessons->sum('kol_chs')}} г.
                </td>
                <td>
                    <a class="btn btn-success" href="{{URL::route('get_lessons',['id'=>$journal->id])}}">
                        Пари
                    </a>
                    <a class="btn btn-primary" href="{{URL::route('get_marks',['id'=>$journal->id])}}">
                        Оцінки
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