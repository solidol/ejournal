@extends('layouts.app-nosidebar')

@section('title', 'Мої табелі')



@section('content')
<h2>
    {{$data['title1']}}
</h2>
<nav class="nav">
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year,'month'=>'08'])}}">Серпень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year,'month'=>'09'])}}">Вересень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year,'month'=>'10'])}}">Жовтень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year,'month'=>'11'])}}">Листопад</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year,'month'=>'12'])}}">Грудень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'01'])}}">Січень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'02'])}}">Лютий</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'03'])}}">Березень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'04'])}}">Квітень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'05'])}}">Травень</a>
    <a class="btn btn-outline-primary m-1" href="{{URL::route('my.calendar',['year'=>$year+1,'month'=>'06'])}}">Червень</a>

</nav>

<div class="div-table">
    <table id="tbtable" class="table table-bordered">
        <thead>
            <tr>
                <th>
                    Дата
                </th>
                <th>
                    1 пара
                </th>
                <th>
                    2 пара
                </th>
                <th>
                    3 пара
                </th>
                <th>
                    4 пара
                </th>
                <th>
                    5 пара
                </th>
                <th>
                    6 пара
                </th>
                <th>
                    7 пара
                </th>
                <th>
                    8 пара
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($arDates as $dateItem)
            <tr>
                <td>
                    {{$dateItem->format('d.m.y')}}
                </td>
                @for($i=1; $i < 9; $i++) 
                <td data-date="{{$dateItem->format('Y-m-d')}}" data-nom-p="{{$i}}">
                    @foreach($teacher->lessons as $lesson)

                    @if($lesson->data_==$dateItem && $lesson->nom_pari==$i)
                    <div id="lesson-{{$lesson->id}}" class="btn btn-primary draggable" draggable="true">
                        {{$lesson->group->title}}
                    </div>
                    @endif

                    @endforeach
                    </td>
                    @endfor
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

<script type="module">
    $(document).ready(function() {
        $('.draggable').on("dragstart", function(event) {
            var dt = event.originalEvent.dataTransfer;
            dt.setData('Text', $(this).attr('id'));
        });
        $('table td').on("dragenter dragover drop", function(event) {
            event.preventDefault();
            if (event.type === 'drop') {
                var data = event.originalEvent.dataTransfer.getData('Text', $(this).attr('id'));
                console.log(data);
                //$('#' + data).detach();
                $('#' + data).appendTo($(this));
            };
        });

    });
</script>
@stop