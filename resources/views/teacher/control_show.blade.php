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
        <a class="nav-link" href="{{URL::route('get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
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
<p>Класний керівник - {{$currentJournal->group->curator->FIO_prep}}</p>
<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>

<ul class="nav nav-pills mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link" href="{{URL::route('get_marks',['id'=>$currentJournal->id])}}">
            Всі разом
        </a>
    </li>
    @foreach ($currentJournal->controls as $control)

    <li class="nav-item" role="presentation">
        <a class="nav-link" href="{{URL::route('show_control',['journal_id'=>$currentJournal->id, 'control_id'=>$control->id])}}">
            {{$control->title}}
        </a>
    </li>
    @endforeach

</ul>





<div class="row">
    <div class="col-lg-8 col-md-12">
        <h3>{{$currentControl->title}}</h3>
        <p class="fs-4">Дата контролю {{!is_null($currentControl->date_)?$currentControl->date_->format('d.m.Y'):''}} | {{$currentControl->type_title}}</p>

        <form action="{{route('store_marks',['id'=>$currentControl->id])}}" method="post">
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Зберегти</button>
            </div>
            <textarea rows="1" class="m-inputs form-control" placeholder="Вставте оцінки сюди CTRL+V"></textarea>

            @csrf
            <table class="table table-striped table-marks m-0">
                <thead>
                    <tr>
                        <th>ПІБ студента</th>
                        <th>Останній вхід</th>
                        <th class="sum">Оцінка</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $studentsCount = $currentJournal->group->students->count();
                    $countYak = 0;
                    $countUsp = 0;
                    ?>

                    @foreach($currentJournal->group->students as $student)
                    <?php
                    if (($control->mark($student->id)->ocenka ?? 0) >= (0.6 * $currentControl->max_grade)) {
                        $countUsp++;
                    }
                    if (($control->mark($student->id)->ocenka ?? 0) >= (0.75 * $currentControl->max_grade)) {
                        $countYak++;
                    }
                    ?>
                    <tr>
                        <td>
                            {{$student->FIO_stud}}
                        </td>
                        <td>
                            {{$student->lastLogin()?$student->lastLogin()->created_at->format('d.m.Y H:m'):'Ніколи'}}
                        </td>
                        <td>
                            <p style="display:none">
                                {{$control->max_grade}}
                            </p>
                            <input type="text" class="form form-control m-0 p-1" name="marks[{{$student->id}}]" value="{{$currentControl->mark($student->id)->mark_str??''}}" placeholder="Max = {{$currentControl->max_grade}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Успішність</th>
                        <th></th>
                        <th>{{round(1000*$countUsp/$studentsCount)/10}} %</th>
                    </tr>
                    <tr>
                        <th>Якість</th>
                        <th></th>
                        <th>{{round(1000*$countYak/$studentsCount)/10}} %</th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="p-2 border border-2 border-primary rounded-2">
            <h3 class="text-danger">Редагування та видалення</h3>
            <div class="mb-3">
                <a href="{{URL::route('delete_control',['id'=>$currentControl->id])}}" class="btn btn-danger m-2" data-confirm="Видалити увесь контроль {{$currentControl->title}} разом з оцінками?">Видалити контроль</a>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('get_info_control',['id'=>$currentControl->id])}}" class="edit-control btn btn-warning m-2">Редагувати контроль</button>
            </div>
        </div>
    </div>
</div>



@include('popups.edit-control')

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
        });

        $(".m-inputs").on('paste', function() {
            var element = this;
            let arInps = $(this).parent().find("table input");
            setTimeout(function() {
                var text = $(element).val();
                console.dir(text);
                $(element).val("");
                let adMarks = text.split("\n");
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