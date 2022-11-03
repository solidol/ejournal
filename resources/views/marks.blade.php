@extends('layouts.app')

@section('title', 'Оцінки')

@section('sidebar')


<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addControl">
    Додати контроль
</button>



<h2>Навігація</h2>

<nav class="nav flex-column">

    <a class="nav-link" href="{{URL::route('get_subjects')}}">Ha головну</a>

</nav>


<h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>

<nav class="nav flex-column d-none d-md-block">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_marks',['subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">{{$mItem->nomer_grup}} - {{ $mItem->subject_name }}</a>
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
            {{ $oSubList['meta']['title'] }}
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent">
    @foreach ($oList as $key=>$oSubList)
    <div class="tab-pane fade <?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'show active' : '' ?> " id="{{$oSubList['meta']['slug']}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $oSubList['meta']['slug'] ?>">
        <form action="{{route('store_marks')}}" method="post">
            @csrf
            <table class="table table-striped">
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
                            <input type="text" class="form form-control" name="marks[{{$oItem->kod_prep}}_{{$oItem->kod_subj}}_{{$oItem->kod_grup}}_{{$oItem->kod_stud}}_{{$oItem->vid_kontrol}}]" value="{{ $oItem->ocenka }}">
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
    @endforeach
</div>

@include('popups.new-control')

@stop