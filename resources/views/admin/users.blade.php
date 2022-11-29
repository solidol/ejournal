@extends('layouts.app')

@section('sidebar')
<h1>Адмінпанель</h1>
<h2>Користувачі</h2>
@endsection

@section('content')

@csrf

<!--
<h2>Користувачі web-інтерфейсу</h2>
<table class="table table-stripped table-bordered">
    <thead>
        <tr>
            <th>
                Ім'я
            </th>
            <th>
                email
            </th>
            <th>
                Роль
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->usertype}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
-->
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
            <td>{{$teacher->FIO_prep}}</td>
            <td>{{$teacher->email}}</td>
            <td>{{$teacher->usertype}}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
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
@endsection