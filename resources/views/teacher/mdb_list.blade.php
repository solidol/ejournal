@extends('layouts.app-nosidebar')

@section('content')
<h1>Електронна база коледжу</h1>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::route('get_method_index')}}">Уся база</a></li>

        @foreach ($breadcrumbs as $bcItem)

        <li class="breadcrumb-item"><a href="{{URL::route('get_method_index')}}?dir={{$bcItem['path']}}">{{$bcItem['title']}}</a></li>

        @endforeach

    </ol>
</nav>

<div class="mb-3 mt-1 table-responsive">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="w-5"><a href="{{URL::route('get_method_index')}}?dir={{$retPath}}"><img src="/assets/img/arrow_180.png"></a></th>
                <th>Ім'я файла</th>
                <th class="w-15">Розмір</th>
                <th class="w-5"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($dirs as $dItem)
            <tr>
                <td><img src="/assets/img/_folder.png" style="width:32px;"></td>
                <td><a href="{{URL::route('get_method_index')}}?dir={{$dItem['path']}}" title="">{{$dItem['title']}}</a></td>
                <td>[DIR]</td>
                <td></td>
            </tr>
            @endforeach

            @foreach($files as $fItem)
            <tr>
                <td><img src="/assets/img/{{$fItem['icon']}}" style="width:32px;"></td>
                <td><a href="{{$fItem['url']}}" title="">{{$fItem['fileName']}}</a></td>
                <td>{{$fItem['fileSize']}}</td>
                <td></td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@stop