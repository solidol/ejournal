@extends('layouts.app')

@section('title', 'Оцінки')

@section('sidebar')

<h2>Навігація</h2>

<nav class="nav flex-column">
    
    <a class="nav-link" href="{{URL::route('get_subjects',['prep'=>$data['prep']])}}">Ha головну</a>
    
</nav>


<h2>Оцінки з інших дисциплін</h2>

<nav class="nav flex-column">
    @foreach($mList as $mItem)
    <a class="nav-link" href="{{URL::route('get_marks',['prep'=>$data['prep'],'subj'=>$mItem->kod_subj,'group'=>$mItem->kod_grup])}}">{{$mItem->nomer_grup}} - {{ mb_convert_encoding($mItem->subject_name, "utf-8", "windows-1251") }}</a>
    @endforeach
</nav>


@stop

@section('content')

<h2>{{$data['title1']}}</h2>

<ul class="nav nav-pills mb-3" role="tablist">
    @foreach ($oList as $key=>$oSubList)

    <li class="nav-item" role="presentation">
        <button class="nav-link <?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'active' : '' ?>" id="<?= 'tl-' . $oSubList['meta']['slug'] ?>" data-bs-toggle="tab" data-bs-target="#{{$oSubList['meta']['slug']}}" type="button" role="tab" aria-controls="<?= $oSubList['meta']['slug'] ?>" aria-selected="<?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'true' : 'false' ?>">
            {{ mb_convert_encoding($oSubList['meta']['title'], "utf-8", "windows-1251") }}
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent">
    @foreach ($oList as $key=>$oSubList)
    <div class="tab-pane fade <?= ($oSubList['meta']['slug'] == 'tab-id1') ? 'show active' : '' ?> " id="{{$oSubList['meta']['slug']}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $oSubList['meta']['slug'] ?>">

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
                        {{ mb_convert_encoding($oItem->FIO_stud, "utf-8", "windows-1251") }}
                    </td>
                    <td>
                        <input type="text" class="form form-control" id="{{$oItem->kod_stud}}_{{$oItem->kod_grup}}_{{$oItem->kod_prep}}_{{$oItem->kod_subj}}" value="{{ $oItem->ocenka }}">
                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    @endforeach
</div>



@stop