@extends('layouts.app-nosidebar')



@section('content')

@csrf
@if($errors->any())
{{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<h2>Користувачі журналу</h2>
<form action="{{ route('users.loginas.post') }}" id="form-login" method="post">
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

    </tbody>
</table>
<script type="module">
    $(document).ready(function() {
        $('.btn-login').click(function() {
            $('#login-userid').val($(this).data('uid'));
            $('#form-login').submit();
        });

        let dt = $('#journal_users').DataTable({
            buttons: [],
            lengthMenu: [50, 100, 500],
            language: languageUk,
            ordering: false,
            processing: true,
            serverSide: true,
            searchDelay: 750,
            ajax: "{{ route('users.index',['slug'=>$slug]) }}",
            columns: [{
                    data: 'fullname',
                    name: 'fullname'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });
</script>

@endsection