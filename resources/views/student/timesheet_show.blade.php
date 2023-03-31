@extends('layouts.app')

@section('title', 'Мої табелі')

@section('sidebar')

<div class="baloon">
    <h1>Мої табелі</h1>
</div>

<div class="baloon d-none d-md-block">
    <h2>Навігація</h2>

    <nav class="nav flex-column">

        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2022','month'=>'08'])}}">Серпень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2022','month'=>'09'])}}">Вересень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2022','month'=>'10'])}}">Жовтень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2022','month'=>'11'])}}">Листопад</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2022','month'=>'12'])}}">Грудень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'01'])}}">Січень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'02'])}}">Лютий</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'03'])}}">Березень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'04'])}}">Квітень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'05'])}}">Травень</a>
        <a class="nav-link" href="{{URL::route('student_get_absents',['year'=>'2023','month'=>'06'])}}">Червень</a>

    </nav>
</div>


@stop


@section('content')
<h2>
    {{$data['title1']}}
</h2>
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="" id="showSubject">
    <label class="form-check-label" for="showSubject">
        Показати повністю назву дисципліни
    </label>
</div>
<div class="div-table">
    <table id="tbtable" class="table table-striped table-bordered table-table m-0">
        <thead>
            <tr>
                <th class="subj-name">
                    Предмет
                </th>
                @foreach($arDates as $dItem)
                <th class="rotated-text sum">

                    {{$dItem['raw']->format('d.m.y')}}

                </th>
                @endforeach
                <th class="rotated-text">
                    Всього
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            <tr>
                <td class="subj-name">
                    {{$journal->subject->subject_name}}
                </td>
                <?php
                $cnt = 0;
                ?>
                @foreach($arDates as $dItem)
                <td class="hr-cnt {{($dItem['dw']=='6' || $dItem['dw']=='0')?'we-cols':''}}">

                    @foreach($journal->lessons as $lesson)
                    @if ($lesson->data_ == $dItem['raw'])
                    <div class="bg-dark text-white">
                        @if ($lesson->absent($user->userable->id))
                        <?php $cnt++; ?>
                        НБ
                        @else
                        &nbsp;
                        @endif
                    </div>
                    @endif
                    @endforeach

                </td>
                @endforeach
                <td class="hr-cnt fw-bold">
                    {{$cnt>0?$cnt:'-'}}
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

<script type="module">
    $(document).ready(function() {
        $('#showSubject').click(function() {
            if ($(this).is(':checked')) {
                $('table th.subj-name, table td.subj-name').css('overflow', 'none');
                $('table th.subj-name, table td.subj-name').css('max-width', 'none');
            } else {
                $('table th.subj-name, table td.subj-name').css('overflow', 'hidden');
                $('table th.subj-name, table td.subj-name').css('max-width', '200px');
            }
        });


        $('#tbtable').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-success'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success'
                }
            ],
            "paging": false,
            "ordering": false,

        });
    });
</script>
@stop