@extends('layouts.app-nosidebar')

@section('title', 'Мої табелі')



@section('content')
<h2>
    {{$data['title1']}}
</h2>
<nav class="nav">
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year,'month'=>'08'])}}">Серпень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year,'month'=>'09'])}}">Вересень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year,'month'=>'10'])}}">Жовтень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year,'month'=>'11'])}}">Листопад</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year,'month'=>'12'])}}">Грудень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'01'])}}">Січень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'02'])}}">Лютий</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'03'])}}">Березень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'04'])}}">Квітень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'05'])}}">Травень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.timesheet',['year'=>$year+1,'month'=>'06'])}}">Червень</a>

</nav>
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
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            @if ($journal->lessonsDate($dateFrom->format('Y-m-d'),$dateTo->format('Y-m-d'))->count() > 0)
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
            @endif
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