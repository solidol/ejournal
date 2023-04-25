@extends('layouts.app')

@section('title', 'Списки моїх студентів')


@section('sidebar')

<div class="baloon">
    <h1>Оцінки</h1>

</div>


<div class="baloon d-none d-md-block">
    <h2 class="d-sm-none d-md-block">Інші мої групи</h2>
    <nav class="nav flex-column d-none d-md-block">
        @foreach($groups as $groupItem)

        <a class="nav-link" href="{{URL::route('corator_local_student_list',['id'=>$groupItem->id])}}">{{$groupItem->title}}</a>

        @endforeach
    </nav>
</div>



@stop


@section('content')

@if ($students)

<h2></h2>


<div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tl-tab-all">
    <table class="table table-striped table-bordered m-0">
        <thead>
            <tr>
                <th>
                    ПІБ
                </th>
                <th>
                    Група
                </th>
                <th>
                    Оцінки
                </th>
                <th>
                    Пропуски
                </th>
                <th>
                    Профіль
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>
                    {{$student->FIO_stud}}
                </td>
                <td>
                    {{$student->group->title}}
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="{{route('corator_local_student_marks',['id'=>$student->id])}}"><i class="bi bi-5-square"></i></a>
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="{{route('curator_local_student_absents',['id'=>$student->id])}}"><i class="bi bi-person-slash"></i></a>
                </td>
                <td>
                    <a class="btn btn-outline-primary" href="{{route('corator_local_student_profile',['id'=>$student->id])}}"><i class="bi bi-person-lines-fill"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif


<script type="module">
    $(document).ready(function() {

        $('.table-marks').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [],
            "paging": false,
            "ordering": false
        });

    });
</script>



@stop