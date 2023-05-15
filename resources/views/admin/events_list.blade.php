@extends('layouts.app-nosidebar')

@section('title', 'Адмінпанель. Журнал подій')


@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
    <h2>Журнал подій</h2>
</div>
@endsection

@section('content')
<h2>Журнал подій</h2>
<table id="logtab" class="table table-stripped table-bordered m-0">
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
        @foreach($arEvents as $event)
        <tr>
            <td>
                {{$event->created_at}}
            </td>
            <td>
                {{$event->user?$event->user->userable->fullname:'Inactive'}}
            </td>
            <td>
                {{$event->roles}}
            </td>
            <td>
                {{$event->event}}
            </td>
            <td>
                {{$event->ip_addr}}
            </td>
            <td>
                {{$event->comment}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex">
    {!! $arEvents->links() !!}
</div>
<script type="module">
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