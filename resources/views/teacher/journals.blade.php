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
            @foreach($mySubjList as $mItem)
            <tr>
                <td>
                    {{$mItem->group->nomer_grup}}
                </td>
                <td>
                    {{$mItem->subject->subject_name}}
                </td>
                <td>
                    {{$mItem->hrsum}} г.
                </td>
                <td>
                    <a class="btn btn-success" href="{{URL::route('get_lessons',['subj'=>$mItem->subject->kod_subj,'group'=>$mItem->group->kod_grup])}}">
                        Пари
                    </a>
                    <a class="btn btn-primary" href="{{URL::route('get_marks',['subj'=>$mItem->subject->kod_subj,'group'=>$mItem->group->kod_grup])}}">
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