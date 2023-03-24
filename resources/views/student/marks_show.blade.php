@extends('layouts.app')

@section('title', 'Оцінки '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)
@section('side-title', 'Оцінки')

@section('sidebar')

<div class="baloon">
    <h2>Оцінки з інших дисциплін</h2>
    <nav class="nav flex-column">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('student_get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
        @endforeach
    </nav>
</div>

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


<table id="dtmarks" class="table table-striped table-bordered m-0">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Дата</th>
            <th>Контроль</th>
            <th>Оцінка</th>
        </tr>
    </thead>
    <tbody>
        @foreach($currentJournal->controls as $control)
        <tr>
            <td>
                {{$control->date_??'2000-01-01'}}
            </td>
            <td>
                {{$control->date_formatted}}
            </td>
            <td>
                {{$control->title}}
            </td>
            <td>
                <b>{{$control->mark(Auth::user()->userable_id)->mark_str??'-'}}</b> з {{$control->max_grade}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



<script type="module">
    $(document).ready(function() {

        $('#dtmarks').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary'
            }],
            paging: false,
            ordering: false,
            searching: false,
            columnDefs: [{
                target: 0,
                visible: false,
            }],
        });


    });
</script>



@stop