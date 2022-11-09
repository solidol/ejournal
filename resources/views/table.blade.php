@extends('layouts.app-nosidebar')

@section('title', 'Мої дисципліни')

@section('content')


<table class="table table-striped table-bordered table-table">
    <thead>
        <tr>
            <th class="subj-name">
                Предмет
            </th>
            @foreach($arDates as $dItem)
            <th class="rotated-text">

                {{$dItem}}

            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($arLessons as $lessList)
        <tr>
            <td class="subj-name">
                {{$lessList['meta']->nomer_grup}} {{$lessList['meta']->subject_name}}
            </td>

            @foreach($arDates as $dItem)
            <td>

                @foreach($lessList['data'] as $lessItem)
                @if ($lessItem->date == $dItem)
                {{$lessItem->kol_chasov}}
                @endif
                @endforeach

            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

@stop