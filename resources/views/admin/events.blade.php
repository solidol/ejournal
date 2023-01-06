@extends('layouts.app')

@section('sidebar')
<h1>Адмінпанель</h1>
<h2>Користувачі</h2>
@endsection

@section('content')

@csrf
@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<h2>Користувачі журналу</h2>
<table id="logtab" class="table table-stripped table-bordered">
    <thead>
        <tr>
            <th>
                Timestamp
            </th>
            <th>
                User
            </th>
            <th>
                Event
            </th>
            <th>
                Comment
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($arEvents as $event)
        <tr>
            <td>
                {{$event->created_at}}
            </td>
            <td>
                {{$event->user->name}}
            </td>
            <td>
                {{$event->event}}
            </td>
            <td>
                {{$event->comment}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {

        $('#logtab').DataTable({
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