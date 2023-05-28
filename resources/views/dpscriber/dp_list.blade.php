@extends('layouts.app-nosidebar')

@section('title', 'Адмінпанель. Мої комісії ДП')


@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
</div>
@endsection

@section('content')
<h1>Мої комісії ДП</h1>
<table id="logtab" class="table table-stripped table-bordered m-0">
    <thead>
        <tr>
            <th>
                Група
            </th>
            <th>
                Голова комісії
            </th>
            <th>
                Члени комісії
            </th>
            <th>
                Секретар
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($dp as $item)
        <tr>
            <td>
                {{$item->group->title}}
            </td>
            <td>
                {{$item->chief}}
            </td>
            <td>
                {{$item->committee}}
            </td>
            <td>
                {{$item->scriber->fullname}}
            </td>
            <td>
                <a href="{{URL::route('diploma_projectings_show',['id'=>$item->id])}}">Переглянути</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<h2>Додати нову</h2>

<form action="{{URL::route('diploma_projectings_store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-1">
            Група:
        </div>
        <div class="col-2">
            <select name="group_id" class="form-select form-select-md" required>
                @foreach ($groups as $gItem)
                <option value="{{$gItem->id}}">{{$gItem->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-1">
            Секретар:
        </div>
        <div class="col-2">
            <select name="scriber_id" class="form-select form-select-md" required>
                @foreach ($teachers as $tItem)
                <option value="{{$tItem->id}}">{{$tItem->fullname}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-1">
            Шаблон:
        </div>
        <div class="col-2">
            <select name="template" class="form-select form-select-md" required>
                
            <option value="121 2023.docx">Прогр інж</option>                
            <option value="123 2023.docx">Комп інж</option>
                
            </select>
        </div>

        <div class="col-3">
            <button type="submit" class="btn btn-success">Зберегти</button>
        </div>
    </div>
</form>


<script type="module">

</script>



@endsection