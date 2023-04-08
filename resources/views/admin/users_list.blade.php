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
<form action="{{ route('admin_another_auth') }}" id="form-login" method="post">
    @csrf
    <input type="hidden" name="userid" id="login-userid" value="">
</form>
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
                Вхід
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                {{$user->userable->fullname}}
            </td>
            <td>{{$user->email}}</td>
            <td>
                <button type="button" class="btn btn-success btn-login" data-uid="{{$user->id}}">
                    Увійти
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type="module">
    $(document).ready(function() {
        $('.btn-login').click(function() {
            $('#login-userid').val($(this).data('uid'));
            $('#form-login').submit();
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

@endsection