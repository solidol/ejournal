@extends('layouts.app')

@section('title', 'Адмінпанель. Мої комісії ДП')


@section('sidebar')

<div class="baloon">
    <h2>Всі комісії</h2>

    <ul>
        @foreach($dp as $item)
        <li>
            <a href="{{URL::route('diploma_projectings_show',['id'=>$item->id])}}">{{$item->group->title}}</a>

        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('content')
<h1>Захист групи {{$currentProjecting->group->title}}</h1>
<h2>Дані про склад комісії</h2>
<form action="{{URL::route('diploma_projectings_update',['id'=>$currentProjecting->id])}}" method="post">
    @csrf
    <div class="row mb-1">
        <div class="col-2">
            Група
        </div>
        <div class="col-4">
            <p class="form-control m-0">{{$currentProjecting->group->title}}</p>
        </div>
        <div class="col-2">
            Секретар
        </div>
        <div class="col-4">
            <select name="scriber_id" class="form-select form-select-md" required>
                @foreach ($teachers as $tItem)
                <option value="{{$tItem->id}}" {{$tItem->id==$currentProjecting->scriber_id?'selected':''}}>{{$tItem->fullname}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-2">
            Голова комісії
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="chief" value="{{$currentProjecting->chief}}">
        </div>
        <div class="col-6">
            (Посада, науковий ступінь, вчене звання, Прізвище Ім'я По-батькові)
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-2">
            Члени комісії
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="committee" value="{{$currentProjecting->committee}}">
        </div>
        <div class="col-6">
            (Прізвище Ім'я По-батькові, Прізвище Ім'я По-батькові, Прізвище Ім'я По-батькові)
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-2">
            Номер комісії
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="com_number" value="{{$currentProjecting->com_number}}">
        </div>
        <div class="col-2">
            Дата комісії
        </div>
        <div class="col-4">
            <input type="date" class="form-control" name="com_date" value="{{$currentProjecting->com_date?$currentProjecting->com_date->format('Y-m-d'):''}}">
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-6">
            <button type="submit" class="btn btn-success">Зберегти</button>
        </div>
    </div>

</form>
<hr>
<h2>Сформовані протоколи</h2>
<table id="logtab" class="table table-stripped table-bordered m-0">
    <thead>
        <tr>
            <th>
                №
            </th>
            <th>
                Номер
            </th>
            <th>
                Студент
            </th>
            <th>
                Тема
            </th>
            <th>
                Керівник
            </th>
            <th>
                Дата
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $item)
        <tr>
            <td>
                {{$item->variant}}
            </td>
            <td>
                {{$item->prot_number}}/{{$item->prot_subnumber}}
            </td>
            <td>
                {{$item->student->fullname}}
            </td>
            <td>
                {{$item->title}}
            </td>
            <td>
                {{$item->teacher->fullname}}
            </td>
            <td>
                {{$item->reporting_date->format('d.m.Y')}}
            </td>
            <td>
                <a href="{{URL::route('diploma_project_show',['id'=>$item->id])}}" class="btn btn-outline-danger"><i class="bi bi-pencil-square"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<hr>
<h2>Додати протокол</h2>
<form action="{{URL::route('diploma_project_store')}}" method="post">
    @csrf
    <input type="hidden" name="diploma_projecting_id" value="{{$currentProjecting->id}}">

    <div class="row mt-3">
        <div class="col-3">
            <label class="form-label">Студент</label>
            <select name="student_id" class="form-select form-select-md" required>
                @foreach ($students as $sItem)
                <option value="{{$sItem->id}}">{{$sItem->fullname}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <label class="form-label">Тема</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="col-3">
            <label class="form-label">Керівник</label>
            <select name="teacher_id" class="form-select form-select-md" required>
                @foreach ($teachers as $tItem)
                <option value="{{$tItem->id}}">{{$tItem->fullname}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col-2">
            <label class="form-label">Дата</label>
            <input type="date" class="form-control" name="reporting_date" required>
        </div>
        <div class="col-2">
            <label class="form-label">Варіант</label>
            <input type="number" class="form-control" name="variant" required>
        </div>
        <div class="col-2">
            <label class="form-label">День/номер</label>
            <div class="input-group">
                <input type="number" class="form-control" name="prot_number">
                <span class="input-group-text">/</span>
                <input type="number" class="form-control" name="prot_subnumber">
            </div>
        </div>

        <div class="col-3">
            <label class="form-label">Тип</label>
            <select name="project_type" class="form-select form-select-md" required>
                <option value="PROG" selected>Програма</option>
                <option value="AIS">АІС</option>
                <option value="WEB">Веб-сайт</option>
                <option value="GRAME">Гра</option>
            </select>
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-3">
            <button type="submit" class="btn btn-success">Зберегти</button>
        </div>
    </div>
</form>



@endsection