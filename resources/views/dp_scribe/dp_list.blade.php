@extends('layouts.app-nosidebar')

@section('title', 'Адмінпанель. Мої комісії ДП')


@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
</div>
@endsection

@section('content')
<h1>Мої комісії ДП</h1>
<table id="logtab" class="table table-stripped table-bordered m-0">
    <thead>
        <tr>
            <th>
                Група
            </th>
            <th>
                Голова комісії
            </th>
            <th>
                Члени комісії
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($dp as $item)
        <tr>
            <td>
                {{$item->group->title}}
            </td>
            <td>
                {{$item->chief}}
            </td>
            <td>
                {{$item->committee}}
            </td>
            <td>
                <a href="{{URL::route('diploma_projectings_show',['id'=>$item->id])}}">Переглянути</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="module">

</script>



@endsection