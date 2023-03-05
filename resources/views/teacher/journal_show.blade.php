@extends('layouts.app')

@section('title', 'Записані пари '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)
@section('side-title', 'Записані пари')

@section('sidebar')
<!-- Button trigger modal -->
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
        <i class="bi bi-clipboard-plus"></i> Записати пару
    </button>
</div>
<h2 class="d-sm-none d-md-block">Інші журнали</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($journals as $journal)
    <a class="nav-link" href="{{URL::route('show_journal',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
    @endforeach
</nav>

@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addLesson"><i class="bi bi-pencil-square"></i> Записати пару</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('get_marks',['id'=>$journal->id])}}"><i class="bi bi-5-square"></i> Оцінки</a>
</li>
@stop

@section('content')

@if (session()->has('message'))
<div class="alert alert-success position-fixed  top-2 start-50 translate-middle" id="success-alert" style="z-index: 11">
    <strong>{{ session('message') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

<h1>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h1>


<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Пари</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Оцінки</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Пропуски</button>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <table id="tblessons" class="display table table-striped">
            <thead>
                <tr>

                    <th>Дата</th>
                    <th class="sum">Г.</th>
                    <th>Тема</th>
                    <th>Задано</th>
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
                        {!! nl2br($lesson->zadanaie) !!}
                    </td>
                    <td>
                        <a class="text-success" href="{{URL::route('show_lesson',['id'=>$lesson->id])}}"><i class="bi bi-pencil-square"></i></a>
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
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <ul>
            <li>
                Н/А, н/а, НА, на - неатестований
            </li>
            <li>
                Зар, зар, З, з - зараховано
            </li>
        </ul>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ПІБ</th>
                    @foreach($currentJournal->controls as $control)
                    <th class="rotate">
                        <div>
                            {{$control->title}}
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($currentJournal->group->students as $student)
                <tr>
                    <td>
                        {{$student->FIO_stud}}
                    </td>
                    @foreach($currentJournal->controls as $control)
                    <td>
                        {{$control->mark($student->id)->mark_str}}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">3...</div>
</div>




<script type="module">
    $(document).ready(function() {

        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });

        table = $('#tblessons').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-primary'
                }
            ],
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
                    console.log(sum); //alert(sum);
                    $(this.footer()).html(sum);
                });
            }
        });


    });
</script>


@include('popups.new-lesson')
@stop