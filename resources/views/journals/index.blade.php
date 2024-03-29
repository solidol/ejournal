@extends('layouts.app-nosidebar')

@section('title', 'Мої дисципліни')
@section('side-title', 'Мої дисципліни')

@section('sidebar')
    <div class="baloon">
        <h2>Новини та повідомлення</h2>
        @foreach ($messages as $mesItem)
            <div class="mb-3 mt-3 p-2 border border-2 border-primary rounded-2">
                <p class="text-danger fs-4">{{ $mesItem->content }}</p>
            </div>
        @endforeach
    </div>

@stop

@section('content')
    <h1>
        Мої дисципліни
        <button type="button" class="mb-1 mt-1 btn btn-danger" data-bs-toggle="modal" data-bs-target="#addLesson">
            Новий журнал
        </button>
    </h1>

    <div class="mb-3 mt-1 table-responsive">

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
                @foreach ($journals as $journal)
                    <tr>
                        <td class="text-center">
                            <div class="btn text-white py-0" style="background-color: <?= $journal->color ?? '#000' ?>;">
                                {{ $journal->group ? $journal->group->nomer_grup : '' }}
                            </div>
                        </td>
                        <td>
                            {{ $journal->subject->subject_name }}
                            @if ($journal->parent)
                                <i class="bi bi-vr fs-5"></i>
                            @endif
                        </td>
                        <td>
                            {{ $journal->lessons->sum('kol_chasov') }} год.
                        </td>
                        <td>

                            <a class="btn btn-success py-0 m-1"
                                href="{{ URL::route('lessons.index', ['id' => $journal->id]) }}">
                                <i class="bi bi-pencil-square"></i> <span class="d-md-inline d-none">Пари</span>
                            </a>
                            <a class="btn btn-primary py-0 m-1" href="{{ URL::route('marks.index', ['id' => $journal->id]) }}">
                                <i class="bi bi-5-square"></i> <span class="d-md-inline d-none">Оцінки</span>
                            </a>

                            <a class="btn btn-danger py-0 m-1"
                                href="{{ URL::route('journals.show', ['journal' => $journal]) }}">
                                <i class="bi bi-book"></i> <span class="d-md-inline d-none">Журнал</span>
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

    @include('journals.popups.create')

@stop
