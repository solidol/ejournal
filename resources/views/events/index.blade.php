@extends('layouts.app-nosidebar')

@section('title', 'Адмінпанель. Журнал подій')


@section('content')
<h2>Журнал подій</h2>
<table id="dttbl" class="mb-3 mt-1 table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                Timestamp
            </th>
            <th>
                User
            </th>
            <th>
                Roles
            </th>
            <th>
                Event
            </th>
            <th>
                IP addr
            </th>
            <th>
                Comment
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script type="module">
    $(document).ready(function() {

        let dt = $('#dttbl').DataTable({
            buttons: [],
            lengthMenu: [100, 500],
            language: languageUk,
            ordering: true,
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: "{{ route('logs.index') }}",
            columns: [{
                data: 'dt',
                name: 'dt'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'roles',
                name: 'roles'
            },
            {
                data: 'event',
                name: 'event'
            },
            {
                data: 'ip_addr',
                name: 'ip_addr'
            },
            {
                data: 'comment',
                name: 'comment'
            }]
        });

    });
</script>

@endsection