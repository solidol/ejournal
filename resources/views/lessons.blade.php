@extends('layouts.app')

@section('title', 'Записані пари '.$data['title1'])
@section('side-title', 'Записані пари')

@section('sidebar')






<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLesson">
    Записати пару
</button>

<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>
    <a class="nav-link" href="{{URL::route('get_marks',['subj'=>$data['subj'],'group'=>$data['group']])}}">Оцінки</a>
</nav>


<h2 class="d-sm-none d-md-block">Записані пари з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">{{$mItem->nomer_grup}} - {{$mItem->subject_name}}</a>
    @endforeach
</nav>

@stop

@section('content')

<h2>{{$data['title1']}}</h2>

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
        @foreach ($oList as $key=>$oItem)
        <tr>

            <td>
                {{ $oItem->date }}
            </td>
            <td class="sum">
                {{ $oItem->kol_chasov }}
            </td>

            <td>
                {!! nl2br($oItem->tema) !!}
            </td>
            <td>
                {!! nl2br($oItem->zadanaie) !!}
            </td>
            <td>
                <a class="text-success" href="{{URL::route('show_lesson',['lessonId'=>$oItem->kod_pari])}}"><i class="bi bi-pencil-square"></i></a>
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

<script>
    $(document).ready(function() {
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