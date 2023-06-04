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
<h1>Захист проекту <<{{$currentProject->title}}>></h1>

<h2>{{$currentProject->student->fullname}}</h2>

<h2>Дані до протоколу</h2>

<form action="{{URL::route('diploma_project_update',['id'=>$currentProject->id])}}" method="post">
    @csrf
    <input type="hidden" name="diploma_projecting_id" value="{{$currentProject->diploma_projecting_id}}">

    <div class="mb-3">
        <label class="form-label">Тема</label>
        <input type="text" class="form-control" name="title" value="{{$currentProject->title}}" required>
    </div>
    <div class="row">
        <div class="col-4">

            <div class="mb-3">
                <label class="form-label">Варіант</label>
                <input type="number" class="form-control" name="variant" min="1" step="1" max="100" value="{{$currentProject->variant}}">
            </div>
            <div class="mb-3">
                <label class="form-label">День/Номер</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="prot_number" value="{{$currentProject->prot_number}}">
                    <span class="input-group-text">/</span>
                    <input type="number" class="form-control" name="prot_subnumber" value="{{$currentProject->prot_subnumber}}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Оцінка</label>
                <input type="number" class="form-control text-danges" name="mark" min="1" step="1" max="100" value="{{$currentProject->mark}}">
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label for="datetime1" class="form-label">Дата захисту</label>
                <input type="date" class="form-control" name="reporting_date" value="{{$currentProject->reporting_date->format('Y-m-d')}}">
            </div>

            <div class="mb-3">
                <label class="form-label">Керівник</label>
                <select name="teacher_id" class="form-select form-select-md" required>
                    @foreach ($teachers as $tItem)
                    <option value="{{$tItem->id}}" {{$tItem->id==$currentProject->teacher_id?'selected':''}}>{{$tItem->fullname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label class="form-label">Сторінок</label>
                <input type="number" class="form-control" name="pages" min="1" step="1" max="200" value="{{$currentProject->pages}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Слайдів</label>
                <input type="number" class="form-control" name="slides" min="1" step="1" max="100" value="{{$currentProject->slides}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Хв захисту</label>
                <input type="number" class="form-control" name="minutes" min="1" step="1" max="100" value="{{$currentProject->minutes}}">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Питання</label>
        <textarea class="form-control" rows="5" name="questions">{{$currentProject->questions}}</textarea>
    </div>
    <div class="row">
        <div class="col-4">
            <button type="submit" class="btn btn-success">Зберегти</button>
        </div>
        <div class="col-4">
            <a href="{{URL::route('diploma_project_prot',['id'=>$currentProject->id])}}" class="btn btn-outline-primary">Протокол</a>
        </div>
        <div class="col-4">
            <a href="{{URL::route('diploma_project_delete',['id'=>$currentProject->id])}}" class="btn btn-outline-danger">Видалити</a>
        </div>
    </div>
</form>



@endsection