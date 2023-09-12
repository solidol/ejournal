@extends('layouts.app-nosidebar')

@section('title', 'Студенти')


@section('content')
<h1>
    Студенти
</h1>

<table id="dttbl" class="mb-3 mt-1 table table-striped table-bordered">
    <thead>
        <tr>
        <th>
                ПІБ
            </th>
            <th>
                Група
            </th>
            <th>
                Журнал
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
            lengthMenu: [50, 100, 500],
            language: languageUk,
            ordering: true,
            processing: true,
            serverSide: true,
            searchDelay: 750,
            ajax: "{{ route('students.index') }}",
            columns: [{
                data: 'FIO_stud',
                name: 'FIO_stud'
            },
            {
                data: 'group',
                name: 'group'
            },
            {
                data: 'action',
                name: 'action'
            }]
        });

    });
</script>



@stop