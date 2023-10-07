@extends('layouts.app-nosidebar')



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
                Вхід
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script type="module">
    $(document).ready(function() {
        $('#journal_users').DataTable({
            buttons: [],
            lengthMenu: [100, 500],
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