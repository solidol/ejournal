@extends('layouts.app')

@section('title', 'Мої табелі')

@section('sidebar')


<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2022','month'=>'08'])}}">Серпень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2022','month'=>'09'])}}">Вересень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2022','month'=>'10'])}}">Жовтень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2022','month'=>'11'])}}">Листопад</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2022','month'=>'12'])}}">Грудень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'01'])}}">Січень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'02'])}}">Лютий</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'03'])}}">Березень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'04'])}}">Квітень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'05'])}}">Травень</a>
    <a class="nav-link" href="{{URL::route('my_table_date',['year'=>'2023','month'=>'06'])}}">Червень</a>

</nav>



@stop


@section('content')

<h2>{{$data['title1']}}</h2>

<div class="div-table">
    <table id="tbtable" class="table table-striped table-bordered table-table">
        <thead>
            <tr>
                <th class="subj-name">
                    Предмет
                </th>
                @foreach($arDates as $dItem)
                <th class="rotated-text">

                    {{$dItem['formatted']}}

                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($arLessons as $lessList)
            <tr>
                <td class="subj-name">
                    {{$lessList['meta']->nomer_grup}} {{$lessList['meta']->subject_name}}
                </td>

                @foreach($arDates as $dItem)
                <td class="hr-cnt {{($dItem['dw']=='6' || $dItem['dw']=='0')?'we-cols':''}}">

                    @foreach($lessList['data'] as $lessItem)
                    @if ($lessItem->date == $dItem['formatted'])
                    {{$lessItem->kol_chasov}}
                    @endif
                    @endforeach

                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tbtable').DataTable({
            dom: 'Bfrtip',
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
            "ordering": false
        });
    });
</script>
@stop