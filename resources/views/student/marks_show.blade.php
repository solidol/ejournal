@extends('layouts.app')

@section('title', 'Оцінки '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)
@section('side-title', 'Оцінки')

@section('sidebar')

<h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>


<nav class="nav flex-column d-none d-md-block">
    @foreach($journals as $journal)
    <a class="nav-link" href="{{URL::route('student_get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
    @endforeach
</nav>


@stop


@section('content')


<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>


<table class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Контроль</th>
            <th>Оцінка</th>
        </tr>
    </thead>
    <tbody>
        @foreach($currentJournal->controls as $control)
        <tr>
            <td>
                {{$control->date_formatted}}
            </td>
            <td>
                {{$control->title}}
            </td>
            <td>
                <b>{{$control->mark(Auth::user()->userable_id)->mark_str?$control->mark(Auth::user()->userable_id)->mark_str:'-'}}</b> з {{$control->max_grade}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



<script type="module">

</script>



@stop