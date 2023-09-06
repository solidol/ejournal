@extends('layouts.app')

@section('title', 'Оцінки '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)


@section('sidebar')

<div class="baloon">
    <h1>Оцінки</h1>
    <h2>
        Контролі
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addControl">
            Додати
        </button>
    </h2>
    <nav class="navbar navbar-light bg-white pt-1 pb-1">
        <div class="d-block d-md-none">
            <a class="navbar-brand" href="#">Інші контролі</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#controlsNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div id="controlsNavbar" class="collapse d-md-block">
            <ul class="navbar-nav mr-auto mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="{{URL::route('get_marks',['id'=>$currentJournal->id])}}">
                        Всі разом
                    </a>
                </li>
                @foreach ($currentJournal->controls as $control)
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::route('controls.show',['control'=>$control])}}">
                        {{$control->title}}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>

    <hr>


    <h2>Оцінки з інших дисциплін</h2>
    <nav class="navbar navbar-light bg-white pt-1 pb-1">
        <div class="d-block d-md-none">
            <a class="navbar-brand" href="#">Інші журнали</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#journalsNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div id="journalsNavbar" class="collapse d-md-block">
            <ul class="navbar-nav mr-auto mb-3">
                @foreach($journals as $journal)
                <li class="nav-item">
                    <a class="nav-link {{($journal->id==$currentJournal->id)?'active':''}}" href="{{URL::route('get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>
@stop

@section('custom-menu')
<li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addControl"><i class="bi bi-pencil-square"></i> Додати контроль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{URL::route('lessons.index',['id'=>$currentJournal->id])}}"><i class="bi bi-list-columns"></i> Пари дисципліни</a>
</li>
@stop

@section('content')


<h2>{{$currentJournal->group->nomer_grup}} - {{$currentJournal->subject->subject_name}}</h2>
<p>Класний керівник - {{$currentJournal->group->curator->FIO_prep}}</p>
<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>
<div class="div-table">
    <table id="table-all" class="table table-striped m-0">
        <thead>
            <tr>
                <th></th>
                <?php $i = 1; ?>
                @foreach($currentJournal->controls as $control)
                <th>
                    <button type="button" class="btn btn-outline-success edit-control p-0 m-0" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('controls.show',['control'=>$control])}}"><i class="bi bi-pencil-square text-light"></i></button>
                </th>
                <?php $i++; ?>
                @endforeach
            </tr>
            <tr>
                <th class="th-naming">ПІБ</th>
                @foreach($currentJournal->controls as $control)
                <th class="rotate sum">
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
        <tfoot>
            <tr>
                <th>Середнє <!--| Успішність | Якість--></th>
                @foreach($currentJournal->controls as $control)
                <th>

                </th>
                @endforeach
            </tr>
        </tfoot>
    </table>
</div>





<script type="module">
    $(document).ready(function() {


        $('#table-all').DataTable({
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
                let api = this.api();
                let rowCount = api
                    .column(0, {
                        page: 'current'
                    })
                    .data()
                    .count();
                api.columns('.sum', {
                    page: 'current'
                }).every(function() {
                    let sum = this
                        .data()
                        .reduce(function(a, b) {
                            return (+a || 0) + (+b || 0);
                        }, 0);
                    $(this.footer()).html(sum > 0 ? Math.round(10 * sum / rowCount) / 10 : '');
                });
            }
        });
    });
</script>

@include('controls.popups.edit')

@include('controls.popups.create')



@stop