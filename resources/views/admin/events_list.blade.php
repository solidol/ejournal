@extends('layouts.app')

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
                {{$event->user?$event->user->name:'Inactive'}}
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