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

<ul>
    <li>
        Н/А, н/а, НА, на - неатестований
    </li>
    <li>
        Зар, зар, З, з - зараховано
    </li>
</ul>

<ul class="nav nav-pills mb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tl-all" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab" aria-controls="all" aria-selected="false">
            Всі
        </button>
    </li>
    <?php $i = 1; ?>
    @foreach ($currentJournal->controls as $control)

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="<?= 'tl-' . $i ?>" data-bs-toggle="tab" data-bs-target="#tab-{{$i}}" type="button" role="tab" aria-controls="{{$i}}" aria-selected="<?= ($i == 1) ? 'true' : 'false' ?>">
            {{$control->title}}
        </button>
    </li>
    <?php $i++; ?>
    @endforeach

</ul>


<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tl-all">
        <table id="table-all" class="table table-striped m-0">
            <thead>
                <tr>
                    <th class="th-naming">ПІБ</th>
                    @foreach($currentJournal->controls as $control)
                    <th class="rotate">
                        <div>
                            {{$control->title}}
                        </div>

                    </th>
                    @endforeach
                </tr>
                <tr>
                    <th></th>
                    <?php $i = 1; ?>
                    @foreach($currentJournal->controls as $control)
                    <th>
                        <button type="button" class="btn btn-outline-success edit-control p-0 m-0"  data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('get_info_control',['id'=>$control->id])}}" ><i class="bi bi-pencil-square text-light"></i></button>
                    </th>
                    <?php $i++; ?>
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

    <?php $i = 1; ?>
    @foreach ($currentJournal->controls as $control)

    <div class="tab-pane fade " id="tab-{{$i}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $i ?>">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h3>Дата контролю {{!is_null($control->date_)?$control->date_->format('d.m.Y'):''}} | {{$control->type_title}}</h3>

                <form action="{{route('store_marks',['id'=>$control->id])}}" method="post">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Зберегти</button>
                    </div>
                    <textarea rows="1" class="m-inputs form-control" placeholder="Вставте оцінки сюди CTRL+V"></textarea>

                    @csrf
                    <table class="table table-striped table-marks m-0">
                        <thead>
                            <tr>
                                <th>ПІБ студента</th>
                                <th class="sum">Оцінка</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentJournal->group->students as $student)
                            <tr>
                                <td>
                                    {{$student->FIO_stud}}
                                </td>
                                <td>
                                    <p style="display:none">
                                        {{$control->max_grade}}
                                    </p>
                                    <input type="text" class="form form-control" name="marks[{{$student->id}}]" value="{{$control->mark($student->id)->mark_str??''}}" placeholder="Max = {{$control->max_grade}}">
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Якість Успішність</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="p-2 border border-2 border-primary rounded-2">
                    <h3 class="text-danger">Редагування та видалення</h3>
                    <div class="mb-3">
                        <a href="{{URL::route('delete_control',['id'=>$control->id])}}" class="btn btn-danger m-2" data-confirm="Видалити увесь контроль {{$control->title}} разом з оцінками?">Видалити контроль</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('get_info_control',['id'=>$control->id])}}" class="edit-control btn btn-warning m-2">Редагувати контроль</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $i++; ?>
    @endforeach


</div>


@include('popups.edit-control')

@include('popups.new-control')


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
            "ordering": false
        });

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
                    //console.log($(this.nodes()));
                    var sum = this
                        .data()
                        .reduce(function(a, b) {
                            var x = parseFloat(a) || 0;
                            var y = parseFloat(b) || 0;
                            return x + y;
                        }, 0);
                    //console.log(sum); //alert(sum);
                    $(this.footer()).html(sum);
                });
            }
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