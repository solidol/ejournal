@extends('layouts.app-nosidebar')

@section('title', 'Мої викладачі')




@section('content')
<h1>
    Мої викладачі
</h1>

<div class="mb-3 mt-1 table-responsive">

    <div class="container">
        @foreach($teachers as $teacher)
        <div class="row m-2 p-1 border border-2 border-primary rounded-2">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <img class="w-75" src="{{route('teacher.avatar.get',['id'=>$teacher->id])}}">
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-xs-12">
                <h2>{{$teacher->fullname}}</h2>
                @foreach($teacher->journalsByGroup($group->kod_grup) as $journal)
                <p><a href="{{route('student_get_marks',['id'=>$journal->id])}}">{{$journal->subject->subject_name}}</a></p>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

</div>


@stop