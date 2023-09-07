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


<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>
                Дата
            </th>
            <th style="width:150px;">
                1 пара
            </th>
            <th style="width:150px;">
                2 пара
            </th>
            <th style="width:150px;">
                3 пара
            </th>
            <th style="width:150px;">
                4 пара
            </th>
            <th style="width:150px;">
                5 пара
            </th>
            <th style="width:150px;">
                6 пара
            </th>
            <th style="width:150px;">
                7 пара
            </th>
            <th style="width:150px;">
                8 пара
            </th>
        </tr>
    </thead>
    <tbody>

        @foreach($arDates as $dateItem)
        <tr>
            <td class="text-center">
                {{$dateItem->format('d.m.y')}}
            </td>
            @for($i=1; $i < 9; $i++) 
            <td data-date="{{$dateItem->format('Y-m-d')}}" data-nom-p="{{$i}}"  class="text-center">
                @foreach($teacher->lessons as $lesson)

                @if($lesson->data_==$dateItem && $lesson->nom_pari==$i)
                <div id="lesson-{{$lesson->id}}" class="btn draggable text-white" style="background-color: <?= $lesson->journal->color ?>;" draggable="true" data-tooltip="{{$lesson->journal->subject->short_title}}. {{$lesson->tema}}" data-url="{{URL::route('lessons.update',['lesson'=>$lesson])}}">
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
<div id="tooltip"></div>

<script type="module">
    $(document).ready(function() {

        $("[data-tooltip]").mousemove(function(eventObject) {



            $("#tooltip").text($(this).attr("data-tooltip"))
                .css({
                    "top": eventObject.pageY + 5,
                    "left": eventObject.pageX + 5
                })
                .show();

        }).mouseout(function() {

            $("#tooltip").hide()
                .text("")
                .css({
                    "top": 0,
                    "left": 0
                });
        });



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $('.draggable').on("dragstart", function(event) {
            var dt = event.originalEvent.dataTransfer;
            dt.setData('Text', $(this).attr('id'));
        });
        $('table td').on("dragenter dragover drop", function(event) {
            event.preventDefault();
            if (event.type === 'drop') {
                var data = event.originalEvent.dataTransfer.getData('Text', $(this).attr('id'));
                $('#' + data).appendTo($(this));
                $.ajax({
                    url: $('#' + data).data('url'),
                    type: 'post',
                    data: {
                        'lessnom': $(this).data('nom-p'),
                        'datetime': $(this).data('date')
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            };
        });

    });
</script>
@stop