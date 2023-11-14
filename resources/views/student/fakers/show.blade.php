@extends('layouts.app-nosidebar')

@section('title', 'Пара')




@section('content')
<h1>
    Генератор фейкових даних
</h1>
<h2>Абзац</h2>
<div class="fs-3">
    {{$fk->paragraph}}
</div>
<hr>
<h2>Слово</h2>
<div class="fs-3">
    {{$fk->word}}
</div>
<hr>
<h2>Речення</h2>
<div class="fs-3">
    {{$fk->sentence}}
</div>
<hr>
<h2>Массив цілих</h2>
<h3>C++</h3>
<div class="fs-3">
    int arInt[] = { {{implode(', ',$fk->ints)}} };
</div>
<h3>PHP</h3>
<div class="fs-3">
    arInt = [ {{implode(', ',$fk->ints)}} ];
</div>
<hr>
<h2>Массив дробних</h2>
<h3>C++</h3>
<div class="fs-3">
    int arFlt[] = { {{implode(', ',$fk->floats)}} };
</div>
<h3>PHP</h3>
<div class="fs-3">
    arFlt = [ {{implode(', ',$fk->floats)}} ];
</div>
@stop