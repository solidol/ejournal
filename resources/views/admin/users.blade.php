@extends('layouts.app')

@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
    <h2>Користувачі</h2>
</div>
@endsection

@section('content')

@csrf
@if($errors->any())
{{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<h2>Користувачі журналу</h2>
<table id="journal_users" class="table table-stripped table-bordered">
    <thead>
        <tr>
            <th>
                Ім'я
            </th>
            <th>
                email
            </th>
            <th>
                Web-доступ
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
        <tr>
            <td data-tid="{{$teacher->kod_prep}}">
                {{$teacher->FIO_prep}}
            </td>
            <td>{{$teacher->email}}</td>
            <td>
                @if (is_null($teacher->email))
                <button type="button" class="btn btn-success btn-adduser" data-bs-toggle="modal" data-bs-target="#addWebuser">
                    Додати
                </button>
                @else
                {{$teacher->usertype}}
                @endif
            </td>
            <td>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.btn-adduser').click(function() {
            let thisrow = $(this).parent().parent();
            let teacher_id = $(thisrow).children().first().data('tid');
            let fullname = $(thisrow).children().first().text().trim();
            $('#name').val(fullname);
            $('#userable_id').val(teacher_id);
        });
        $('#journal_users').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-success'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success'
                }
            ],
            "paging": false,
            "ordering": false
        });
    });
</script>

@include('popups.new-webuser')

@endsection