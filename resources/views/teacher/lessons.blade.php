@extends('layouts.app')

@section('title', 'Записані пари '.$data['title1'])
@section('side-title', 'Записані пари')

@section('sidebar')
<!-- Button trigger modal -->
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
        <i class="bi bi-clipboard-plus"></i> Записати пару
    </button>
</div>
<h2 class="d-sm-none d-md-block">Записані пари з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grupi])}}">{{$mItem->group->nomer_grup}} - {{$mItem->subject->subject_name}}</a>
    @endforeach
</nav>

@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addLesson"><i class="bi bi-pencil-square"></i> Записати пару</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('get_marks',['subj'=>$data['subj'],'group'=>$data['group']])}}"><i class="bi bi-5-square"></i> Оцінки</a>
</li>
@stop

@section('content')

@if (session()->has('message'))
<div class="alert alert-success position-fixed  top-2 start-50 translate-middle" id="success-alert" style="z-index: 11">
    <strong>{{ session('message') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

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
                {{ $oItem->data_?$oItem->data_->format('d.m.y'):'' }}
            </td>
            <td class="sum">
                {{ $oItem->kol_chasov }}
            </td>

            <td>
                {!! nl2br($oItem->tema) !!}
                @if ($oItem->hasControl())
                <span class="badge rounded-pill text-bg-danger">контроль</span>
                @endif
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
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLesson">
        <i class="bi bi-clipboard-plus"></i> Записати пару
    </button>
</div>

<script>
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