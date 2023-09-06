@extends('layouts.app-nosidebar')

@section('title', 'Студенти')
@section('side-title', 'Студенти')

@section('sidebar')



@stop

@section('content')
<h1>
    Студенти
</h1>

<form method="post">
    @csrf
    <div class="mb-3">
        <label class="form-label">ПІБ студента або частина</label>
        <input type="text" name="fullname" class="form-control" placeholder="ПІБ студента або частина">
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Шукати</button>
</form>

<div class="mb-3 mt-1 table-responsive">

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
                    Відкрити
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
                    {{$student->group->nomer_grup}}
                </td>

                <td>
                    <a class="btn btn-success pt-0 pb-0" href="{{route('journals.index',['group'=>$student->group->id])}}">
                        <i class="bi bi-pencil-square"></i> Журнали
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>

                </th>
                <th>

                </th>
                <th>

                </th>
                <th>

                </th>
            </tr>
        </tfoot>
    </table>
    @if (!empty($students))
    {!! $students->links() !!}
    @endif
</div>



@stop