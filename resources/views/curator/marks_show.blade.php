@extends('layouts.app')

@section('title', 'Оцінки класного керівника')


@section('sidebar')

<div class="baloon">
    <h1>Оцінки</h1>

</div>


<div class="baloon d-none d-md-block">
    <h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>
    <nav class="nav flex-column d-none d-md-block">
        @foreach($groups as $groupItem)
        @foreach($groupItem->journals as $journal)
        <a class="nav-link" href="{{URL::route('curator_get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
        @endforeach
        <hr>
        @endforeach
    </nav>
</div>



@stop

@section('content')

@if ($currentJournal)

<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>

<p>Викладач - {{$currentJournal->teacher->FIO_prep}}</p>

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>


<div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tl-tab-all">
    <table class="table table-striped table-bordered m-0">
        <thead>
            <tr>
                <th>ПІБ</th>
                @foreach($currentJournal->controls as $control)
                <th class="rotate">
                    <div>
                        {{$control->title}}
                    </div>

                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($currentJournal->group->students as $student)
            <tr>
                <td>
                    {{$student->FIO_stud}}
                </td>
                @foreach($currentJournal->controls as $control)
                <td>
                    {{$control->mark($student->id)->mark_str??'-'}}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif


<script type="module">
    $(document).ready(function() {

        $('.table-marks').DataTable({
            dom: 'Bfrtip',
            language: languageUk,
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-primary'
                }
            ],
            "paging": false,
            "ordering": false,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();
                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    console.log($(this.nodes()));
                    var sum = this
                        .data()
                        .reduce(function(a, b) {
                            var x = parseFloat(a) || 0;
                            var y = parseFloat(b) || 0;
                            return x + y;
                        }, 0);
                    console.log(sum); //alert(sum);
                    $(this.footer()).html(sum);
                });
            }
        });

    });
</script>



@stop