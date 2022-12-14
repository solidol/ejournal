@extends('layouts.app')

@section('title', 'Мої дисципліни')
@section('side-title', 'Мої дисципліни')

@section('sidebar')



@stop

@section('content')

<div class="mb-3 mt-1 row row-cols-1 row-cols-xl-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 g-4 card-row">

    @foreach($mySubjList as $mItem)
    <div class="col">
        <div class="card h-100">
            <div class="card-header text-white bg-dblue">
                <h3><i class="bi bi-people"></i> {{$mItem->group->nomer_grup}} | Вичитано {{$mItem->hrsum}} г.</h3>
            </div>
            <div class="card-body">
                <h5><i class="bi bi-book"></i> {{$mItem->subject->subject_name}} </h5>
            </div>
            <div class="card-footer">
                <p>
                    <a class="btn btn-success" href="{{URL::route('get_lessons',['subj'=>$mItem->subject->kod_subj,'group'=>$mItem->group->kod_grup])}}">
                        Пари
                    </a>
                    <a class="btn btn-primary" href="{{URL::route('get_marks',['subj'=>$mItem->subject->kod_subj,'group'=>$mItem->group->kod_grup])}}">
                        Оцінки
                    </a>
                </p>
            </div>
        </div>
    </div>
    @endforeach

    <div class="col">
        <div class="card h-100">
            <div class="card-header text-white bg-dblue">
                <h3><i class="bi bi-people"></i> Створити</h3>
            </div>
            <div class="card-body">
                <h5><i class="bi bi-book"></i> Створити новий журнал</h5>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addLesson">
                    Розпочати
                </button>
            </div>
        </div>
    </div>

</div>

@include('popups.new-journal')

@stop