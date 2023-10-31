@extends('layouts.app')

@section('title', 'Оцінки '. $control->journal->group->nomer_grup ." - " .$control->journal->subject->subject_name)

@section('sidebar')

<div class="baloon">
    <h1>Оцінки</h1>
    <h2>
        Лабораторні
    </h2>

</div>
@stop


@section('content')

<h2>{{$control->title}}</h2>
<p class="fs-4">Пов'язана пара: {{$control->lesson->tema??''}}</p>
<p class="fs-4">Дата контролю {{!is_null($control->date_)?$control->date_->format('d.m.Y'):''}} | {{$control->type_title}}</p>

<h3>
    Прикриплені матеріали
</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Назва</th>
            <th>Посилання</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($control->additionals as $additional)
        <tr>
            <td>
                {{$additional->title}}
            </td>
            <td>
                <a href="{{$additional->link}}" target="_blank" class="link-15px">{{$additional->link}}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Статус</h2>
@if ($control->mark($student->id)->mark_str??false)
<p class="fs-3 text-success p-2 border border-2 border-success rounded-2">Зараховано {{$control->mark($student->id)->data_->format('d.m.Y')}}</p>
@else
<p class="fs-3 text-danger p-2 border border-2 border-danger rounded-2">Оцінка відсутня</p>
@endif


<script type="module">
    $(document).ready(function() {


    });
</script>



@stop