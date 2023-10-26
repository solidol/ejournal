@extends('layouts.app-nosidebar')

@section('title', 'Мої пропуски')




@section('content')
<h1>Мої пропуски</h1>
<h2>
    {{$data['title1']}}
</h2>

<nav class="nav">
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year,'month'=>'08'])}}">Серпень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year,'month'=>'09'])}}">Вересень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year,'month'=>'10'])}}">Жовтень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year,'month'=>'11'])}}">Листопад</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year,'month'=>'12'])}}">Грудень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'01'])}}">Січень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'02'])}}">Лютий</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'03'])}}">Березень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'04'])}}">Квітень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'05'])}}">Травень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('student.absents.index',['year'=>$year+1,'month'=>'06'])}}">Червень</a>

</nav>


<div class="div-table">
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="" id="showSubject">
        <label class="form-check-label" for="showSubject">
            Показати повністю назву дисципліни
        </label>
    </div>
    <table id="tbtable" class="table table-striped table-bordered table-table m-0">
        <thead>
            <tr>
                <th class="subj-name">
                    Предмет
                </th>
                <th class="subj-name">
                    Викладач
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
            @if ($journal->lessonsDate($dateFrom->format('Y-m-d'),$dateTo->format('Y-m-d'))->count() > 0)
            <tr>

                <td class="subj-name">
                    {{$journal->subject->subject_name}}
                </td>
                <td class="subj-name">
                    {{$journal->teacher->fullname}}
                </td>
                <?php
                $cnt = 0;
                ?>
                @foreach($arDates as $dItem)
                <td class="hr-cnt {{($dItem['dw']=='6' || $dItem['dw']=='0')?'we-cols':''}}">

                    @foreach($journal->lessonsDate($dateFrom->format('Y-m-d'),$dateTo->format('Y-m-d'))->get() as $lesson)
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
            @endif
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