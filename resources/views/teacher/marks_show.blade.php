@extends('layouts.app')

@section('title', 'Оцінки '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')

<div class="baloon">
    <h1>Оцінки</h1>
    <div class="mb-3 mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addControl">
            Додати контроль
        </button>
    </div>
</div>


<div class="baloon d-none d-md-block">
    <h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>
    <nav class="nav flex-column d-none d-md-block">
        @foreach($journals as $journal)
        <a class="nav-link" href="{{URL::route('get_marks_sheet',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
        @endforeach
    </nav>
</div>



@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addControl"><i class="bi bi-pencil-square"></i> Додати контроль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('show_journal',['id'=>$currentJournal->id])}}"><i class="bi bi-list-columns"></i> Пари дисципліни</a>
</li>
@stop

@section('content')


<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>

<ul class="nav nav-pills mb-3">
    <li class="nav-item" role="presentation">
        <a href="{{URL::route('show_journal',['id'=>$currentJournal->id])}}" class="btn nav-link">Пари</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="btn nav-link active">Оцінки</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="btn nav-link">Пропуски</a>
    </li>
</ul>

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>


<div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tl-tab-all">
    <table class="table table-striped table-bordered">
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
            <th></th>
            @foreach($currentJournal->controls as $control)
            <th>
                <a class="text-success" href="#"><i class="bi bi-pencil-square text-light"></i></a>
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

@include('popups.new-control')


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

        $(".m-inputs").on('paste', function() {
            var element = this;
            let arInps = $(this).parent().find("table input");
            setTimeout(function() {
                var text = $(element).val();
                $(element).val("");
                let adMarks = text.split(' ');
                if (arInps.length == adMarks.length) {

                    for (let i = 0; i <= adMarks.length - 1; i++) {
                        arInps[i].value = adMarks[i];
                    }
                } else {
                    alert('Кількість оцінок і рядків не співпадають');
                }
            }, 100);
        });
    });
</script>



@stop