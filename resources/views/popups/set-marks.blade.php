@extends('layouts.app')

@section('title', 'Оцінки '.$data['title1'])
@section('side-title', 'Оцінки')

@section('sidebar')


<!-- Button trigger modal -->
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addControl">
        Додати контроль
    </button>
</div>

<h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_marks',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grupi])}}">{{$mItem->group->nomer_grup}} - {{ $mItem->subject->subject_name }}</a>
    @endforeach
</nav>


@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addControl"><i class="bi bi-pencil-square"></i> Додати контроль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('lessons.index',['subj'=>$lesson->kod_subj,'group'=>$lesson->kod_grupi])}}"><i class="bi bi-list-columns"></i> Пари дисципліни</a>
</li>
@stop

@section('content')
@if (session()->has('message'))
<div class="message-alert alert alert-success position-fixed  top-2 start-50 translate-middle" style="z-index: 11">
    <strong>{{ session('message') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

@if (session()->has('warning'))
<div class="message-alert alert alert-danger position-fixed  top-2 start-50 translate-middle" style="z-index: 11">
    <strong>{{ session('warning') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif
<h2>{{$data['title1']}}</h2>

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>

<ul class="nav nav-pills mb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tl-tab-all" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab" aria-controls="<?= $oSubList['meta']['slug'] ?>" aria-selected="<?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'true' : 'false' ?>">
            Всі оцінки
        </button>
    </li>
    @foreach ($oList as $key=>$oSubList)

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="<?= 'tl-' . $oSubList['meta']['slug'] ?>" data-bs-toggle="tab" data-bs-target="#{{$oSubList['meta']['slug']}}" type="button" role="tab" aria-controls="<?= $oSubList['meta']['slug'] ?>" aria-selected="<?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'true' : 'false' ?>">
            {{ $oSubList['meta']['title'] }} ({{$oSubList['meta']['maxval']}}б.)
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tl-tab-all">
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
    @foreach ($oList as $key=>$oSubList)
    <div class="tab-pane fade  " id="{{$oSubList['meta']['slug']}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $oSubList['meta']['slug'] ?>">
        <h3>Дата контролю {{date_format(date_create($oSubList['meta']['data_']),'d.m.y')}} | {{$oSubList['meta']['typecontrol']}}</h3>

        <form action="{{route('store_marks')}}" method="post">
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Зберегти</button>
            </div>
            <input type="text" class="m-inputs form-control" placeholder="Вставте оцінки сюди CTRL+V">
            <input type="hidden" name="cdate" value="{{$oSubList['meta']['data_']}}">
            @csrf
            <table class="table table-striped table-marks">
                <thead>
                    <tr>
                        <th>ПІБ студента</th>
                        <th class="sum">Оцінка</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($oSubList['data'] as $oItem)
                    <tr>
                        <td>
                            {{ $oItem->FIO_stud}}
                        </td>
                        <td>
                            <p style="display:none">
                                {{ $oItem->ocenka }}
                            </p>
                            <input type="text" class="form form-control" name="marks[{{$oItem->kod_prep}}_{{$oItem->kod_subj}}_{{$oItem->kod_grup}}_{{$oItem->kod_stud}}_{{$oItem->vid_kontrol}}]" value="{{ $oItem->ocenka }}" placeholder="Max = {{$oSubList['meta']['maxval']}}">
                        </td>


                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Якість Успішність</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </form>
        <h3 class="text-danger">Редагування та видалення</h3>
        <div class="mb-3">
            <a href="{{URL::route('delete_control',['subj'=>$oSubList['meta']['subj'], 'group'=>$oSubList['meta']['group'], 'control'=>$oSubList['meta']['title']])}}" class="btn btn-danger" data-confirm="Видалити увесь контроль {{$oSubList['meta']['title']}} разом з оцінками?">Видалити контроль</a>
            <button type="button" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('controls.show',['control'=>$currentControl])}}" class="edit-control btn btn-warning">Редагувати контроль</button>
        </div>
    </div>
    @endforeach
</div>

<script type="module">
    $(document).ready(function() {
        $(".message-alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".message-alert").slideUp(500);
        });
        $('.table-marks').DataTable({
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
                    console.log($(this.nodes()));
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

        $(".m-inputs").on('paste', function() {
            var element = this;
            let arInps = $(this).parent().find("table input");
            setTimeout(function() {
                var text = $(element).val();
                $(element).val("");
                let adMarks = text.split(' ');
                if (arInps.length == adMarks.length) {

                    for (let i = 0; i <= adMarks.length - 1; i++) {
                        arInps[i].value = adMarks[i];
                    }
                } else {
                    alert('Кількість оцінок і рядків не співпадають');
                }
            }, 100);
        });
    });
</script>

@include('controls.popups.create')

@include('controls.popups.edit')

@stop