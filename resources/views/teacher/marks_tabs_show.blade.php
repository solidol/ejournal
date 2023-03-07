@extends('layouts.app')

@section('title', 'Оцінки '. $currentJournal->group->nomer_grup ." - " .$currentJournal->subject->subject_name)
@section('side-title', 'Оцінки')

@section('sidebar')


<!-- Button trigger modal -->
<div class="mb-3 mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addControl">
        Додати контроль
    </button>
</div>

<h2 class="d-sm-none d-md-block">Оцінки з інших дисциплін</h2>


<nav class="nav flex-column d-none d-md-block">
    @foreach($journals as $journal)
    <a class="nav-link" href="{{URL::route('get_marks',['id'=>$journal->id])}}">{{$journal->group->nomer_grup}} - {{$journal->subject->subject_name}}</a>
    @endforeach
</nav>




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

<ul class="nav nav-pills mb-3" role="tablist">
    <?php $i = 1; ?>
    @foreach ($currentJournal->controls as $control)

    <li class="nav-item" role="presentation">
        <button class="nav-link <?= ($i == 1) ? 'active' : '' ?>" id="<?= 'tl-' . $i ?>" data-bs-toggle="tab" data-bs-target="#tab-{{$i}}" type="button" role="tab" aria-controls="{{$i}}" aria-selected="<?= ($i == 1) ? 'true' : 'false' ?>">
            {{$control->title}}
        </button>
    </li>
    <?php $i++; ?>
    @endforeach
</ul>


<div class="tab-content" id="myTabContent">
    <?php $i = 1; ?>
    @foreach ($currentJournal->controls as $control)
    <div class="tab-pane fade <?= ($i == 1) ? 'show active' : '' ?> " id="tab-{{$i}}" role="tabpanel" aria-labelledby="<?= 'tl-' . $i ?>">
        <h3>Дата контролю {{!is_null($control->date_)?$control->date_->format('d.m.Y'):''}} | {{$control->type_title}}</h3>

        <form action="{{route('store_marks')}}" method="post">
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Зберегти</button>
            </div>
            <input type="text" class="m-inputs form-control" placeholder="Вставте оцінки сюди CTRL+V">
            <input type="hidden" name="control_id" value="{{$control->id}}">
            @csrf
            <table class="table table-striped table-marks">
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
                            <input type="text" class="form form-control" name="marks[{{$control->id}}_{{$student->id}}]" value="{{$control->mark($student->id)->mark_str}}" placeholder="Max = {{$control->max_grade}}">
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
        <h3 class="text-danger">Редагування та видалення</h3>
        <div class="mb-3">
            <a href="{{URL::route('delete_control',['id'=>$control->id])}}" class="btn btn-danger" data-confirm="Видалити увесь контроль {{$control->title}} разом з оцінками?">Видалити контроль</a>
            <button type="button" data-bs-toggle="modal" data-bs-target="#editControl" data-url="{{URL::route('get_info_control',['id'=>$control->id])}}" class="edit-control btn btn-warning">Редагувати контроль</button>
        </div>
    </div>
    <?php $i++; ?>
    @endforeach
</div>




@include('popups.new-control')


<script type="module">
    $(document).ready(function() {

        $('.table-marks').DataTable({
            dom: 'Bfrtip',
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