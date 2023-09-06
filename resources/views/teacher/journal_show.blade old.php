@extends('layouts.app')

@section('title', 'Записані пари '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')
<div class="baloon">
    <h1>Записані пари</h1>
    <div class="mb-3 mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
            <i class="bi bi-clipboard-plus"></i> Записати пару
        </button>
    </div>
</div>

<div class="baloon d-none d-md-block">
    <h2>Інші журнали</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('show_journal',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
        @endforeach
    </nav>
</div>

@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addLesson"><i class="bi bi-pencil-square"></i> Записати пару</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('get_marks',['id'=>$currentJournal->id])}}"><i class="bi bi-5-square"></i> Оцінки</a>
</li>
@stop

@section('content')


<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>
<p>Класний керівник - {{$currentJournal->group->curator->FIO_prep}}</p>
<table id="tblessons" class="display table table-striped m-0">
    <thead>
        <tr>

            <th>Дата</th>
            <th class="sum">Г.</th>
            <th>Тема</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($currentJournal->lessons as $lesson)
        <tr>

            <td>
                {{ $lesson->data_?$lesson->data_->format('d.m.y'):'' }}
            </td>
            <td class="sum">
                {{ $lesson->kol_chasov }}
            </td>
            <td>
                {!! nl2br($lesson->tema) !!}
                @if ($lesson->hasControl())
                <span class="badge rounded-pill text-bg-danger">контроль</span>
                @endif
            </td>
            <td>
                <a class="btn btn-success m-1" href="{{URL::route('lessons.show',['lesson'=>$lesson])}}">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-outline-danger show-lesson m-1" href="#" data-bs-toggle="modal" data-bs-target="#viewLesson" data-url="{{route('get_info_lesson',['id'=>$lesson->id])}}">
                    <i class="bi bi-exclamation-triangle"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>

            <th>Всього</th>
            <th class="sum"></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
        <i class="bi bi-clipboard-plus"></i> Записати пару
    </button>
</div>
</div>

@include('popups.show-lesson')

<script type="module">
    $(document).ready(function() {
        $('#tblessons').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary'
            }],
            "paging": false,
            "ordering": false,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();
                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    var sum = this
                        .data()
                        .reduce(function(a, b) {
                            var x = parseFloat(a) || 0;
                            var y = parseFloat(b) || 0;
                            return x + y;
                        }, 0);
                    $(this.footer()).html(sum);
                });
            }
        });


    });
</script>


@include('popups.new-lesson')
@stop