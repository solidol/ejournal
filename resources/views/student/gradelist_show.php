@extends('layouts.app')

@section('title', 'Мої табелі')
@section('side-title', 'Мої табелі')
@section('sidebar')


<h2>Навігація</h2>

<nav class="nav flex-column">



    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>'08'])}}">Серпень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>'09'])}}">Вересень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>'10'])}}">Жовтень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>'11'])}}">Листопад</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>'12'])}}">Грудень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'01'])}}">Січень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'02'])}}">Лютий</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'03'])}}">Березень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'04'])}}">Квітень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'05'])}}">Травень</a>
    <a class="nav-link" href="{{URL::route('my_timesheet_date',['year'=>'2023','month'=>'06'])}}">Червень</a>

</nav>



@stop


@section('content')
<h2>
    <!--<a href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>$data['last_mon']])}}" class="btn btn-primary"><i class="bi bi-caret-left"></i></a>-->
    {{$data['title1']}}
    <!--<a href="{{URL::route('my_timesheet_date',['year'=>'2022','month'=>$data['next_mon']])}}" class="btn btn-primary"><i class="bi bi-caret-right"></i></a>-->
</h2>
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="" id="showSubject">
    <label class="form-check-label" for="showSubject">
        Показати повністю назву дисципліни
    </label>
</div>
<div class="div-table">
    <table id="tbtable" class="table table-striped table-bordered table-table">
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
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            <tr>
                <td class="subj-name">
                    {{$journal->group->nomer_grup}} {{$journal->subject->subject_name}}
                </td>

                @foreach($arDates as $dItem)
                <td class="hr-cnt {{($dItem['dw']=='6' || $dItem['dw']=='0')?'we-cols':''}}">

                    @foreach($journal->lessons as $lesson)
                    @if ($lesson->data_ == $dItem['raw'])
                    {{$lesson->kol_chasov}}
                    @endif
                    @endforeach

                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>
                    Всього за день:
                </th>
                @foreach($arDates as $dItem)
                <th>
                </th>
                @endforeach
            </tr>
        </tfoot>
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

                    $(this.footer()).html(sum > 0 ? sum : '');
                    if (sum > 8) {
                        $(this.footer()).css('color', 'red');
                        $(this.footer()).css('background-color', 'white');
                    } else {
                        $(this.footer()).css('color', '');
                        $(this.footer()).css('background-color', '');
                    }
                });
            }
        });
    });
</script>
@stop