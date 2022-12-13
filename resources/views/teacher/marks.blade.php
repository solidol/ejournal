@extends('layouts.app')

@section('title', 'Оцінки '.$data['title1'])
@section('side-title', 'Оцінки')

@section('sidebar')


<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addControl">
    Додати контроль
</button>



<h2>Навігація</h2>

<nav class="nav flex-column">
    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>
    <a class="nav-link" href="{{URL::route('get_lessons',['subj'=>$lesson->kod_subj,'group'=>$lesson->kod_grupi])}}">Всі пари дисципліни</a>
</nav>


<h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_marks',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grupi])}}">{{$mItem->group->nomer_grup}} - {{ $mItem->subject->subject_name }}</a>
    @endforeach
</nav>


@stop

@section('content')

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
    @foreach ($oList as $key=>$oSubList)

    <li class="nav-item" role="presentation">
        <button class="nav-link <?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'active' : '' ?>" id="<?= 'tl-' . $oSubList['meta']['slug'] ?>" data-bs-toggle="tab" data-bs-target="#{{$oSubList['meta']['slug']}}" type="button" role="tab" aria-controls="<?= $oSubList['meta']['slug'] ?>" aria-selected="<?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'true' : 'false' ?>">
            {{ $oSubList['meta']['title'] }} ({{$oSubList['meta']['maxval']}}б.)
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent">
    @foreach ($oList as $key=>$oSubList)
    <div class="tab-pane fade <?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'show active' : '' ?> " id="{{$oSubList['meta']['slug']}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $oSubList['meta']['slug'] ?>">
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
                        <th>Оцінка</th>
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
            </table>
        </form>
        <h3 class="text-danger">Редагування та видалення</h3>
        <div class="mb-3">
            <a href="{{URL::route('delete_control',['subj'=>$oSubList['meta']['subj'], 'group'=>$oSubList['meta']['group'], 'control'=>$oSubList['meta']['title']])}}" class="btn btn-danger" data-confirm="Видалити увесь контроль {{$oSubList['meta']['title']}} разом з оцінками?">Видалити контроль</a>
            <button type="button" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('get_info_control',['subj'=>$oSubList['meta']['subj'], 'group'=>$oSubList['meta']['group'], 'control'=>$oSubList['meta']['title']])}}" class="edit-control btn btn-warning">Редагувати контроль</button>
        </div>
    </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {

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

@include('popups.new-control')

@include('popups.edit-control')

@stop