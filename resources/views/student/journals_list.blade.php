@extends('layouts.app')

@section('title', 'Оцінки. Всі журнали')
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


<h2>Оцінки. Оберіть журнал</h2>

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>


<script type="module">

</script>



@stop