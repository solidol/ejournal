@extends('layouts.app-nosidebar')

@section('content')
    <h1>Заміни {{ $replacements[0]->NAME }}</h1>
    <style>
        .div-rp table{
            
        }
        .div-rp table td{
            border: 1px solid black! important;
            padding: 0.4rem;
        }
        .div-rp table *{
            text-align: center;
            padding: 0;
            margin: 0;
        }
        .clear { clear: both; }
    </style>
    <div class="div-rp">
        {!! $replacements[0]->PREVIEW_TEXT !!}
    </div>
    <br class="clear" />
@stop
