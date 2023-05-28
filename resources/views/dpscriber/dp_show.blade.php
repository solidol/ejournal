@extends('layouts.app-nosidebar')

@section('title', 'Адмінпанель. Мої комісії ДП')


@section('sidebar')
<div class="baloon">
    <h1>Захист проекту</h1>
</div>
@endsection

@section('content')
<h1>Захист проекту</h1>
<form action="{{URL::route('diploma_projectings_update',['id'=>$currentProjecting->id])}}" method="post">
    @csrf
    <div class="row mb-1">
        <div class="col-2">
            Група
        </div>
        <div class="col-4">
            <p class="form-control m-0">{{$currentProjecting->group->title}}</p>
        </div>
        <div class="col-6">
            
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
    <button type="submit" class="btn btn-success">Зберегти</button>
</form>
<table id="logtab" class="table table-stripped table-bordered m-0">
    <thead>
        <tr>
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
                День/номер
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $item)
        <tr>
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
                {{$item->reporting_date}}
            </td>
            <td>
                {{$item->prot_number}}/{{$item->prot_subnumber}}
            </td>
            <td>
                <a href="{{URL::route('diploma_project_delete',['id'=>$item->id])}}" class="btn btn-outline-danger"><i class="bi bi-trash"></i></a>
                <a href="{{URL::route('diploma_project_prot',['id'=>$item->id])}}" class="btn btn-outline-danger">Протокол</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="{{URL::route('diploma_project_store')}}" method="post">
    @csrf
    <input type="hidden" name="diploma_projecting_id" value="{{$currentProjecting->id}}">
    <div class="row">
        <div class="col-3">
            Студент
        </div>
        <div class="col-6">
            Тема
        </div>
        <div class="col-3">
            Керівник
        </div>

    </div>
    <div class="row">
        <div class="col-3">
            <select name="student_id" class="form-select form-select-md" required>
                @foreach ($students as $sItem)
                <option value="{{$sItem->id}}">{{$sItem->fullname}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="col-3">
            <select name="teacher_id" class="form-select form-select-md" required>
                @foreach ($teachers as $tItem)
                <option value="{{$tItem->id}}">{{$tItem->fullname}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">

        <div class="col-3">
            Дата
        </div>
        <div class="col-3">
            День/номер
        </div>
        <div class="col-3">
            Тип
        </div>
        <div class="col-3">
            Додати
        </div>
    </div>
    <div class="row">

        <div class="col-3">
            <input type="date" class="form-control" name="reporting_date" required>
        </div>
        <div class="col-3">
            <div class="input-group">
                <input type="text" class="form-control" name="prot_number">
                <span class="input-group-text">/</span>
                <input type="text" class="form-control" name="prot_subnumber">
            </div>
        </div>

        <div class="col-3">
            <select name="project_type" class="form-select form-select-md" required>
                <option value="PROG" selected>Програма</option>
                <option value="AIS">АІС</option>
                <option value="WEB">Веб-сайт</option>
                <option value="GRAME">Гра</option>
            </select>
        </div>

        <div class="col-3">
            <button type="submit" class="btn btn-success">Зберегти</button>
        </div>
    </div>
</form>



@endsection