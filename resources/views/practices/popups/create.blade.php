<!-- Modal -->
<form action="{{URL::route('practices.store')}}" method="post">
    @csrf
    <div class="modal fade" id="addPractice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Додати абораторну (практичну) роботу</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="journal_id" value="{{$currentJournal->id}}">

                    <div class="mb-3">
                        <label for="control" class="form-label">Тема лабораторної (практичної)</label>
                        <input type="text" class="form-control" id="control" name="title" placeholder="Введіть тему" required>
                    </div>
                    <div class="mb-3">
                        <label for="datetAddControl" class="form-label">Дата проведення</label>
                        <input type="date" class="form-control" id="dateAddControl" name="date_control" value="{{$lesson?$lesson->data_->format('Y-m-d'):''}}" required>
                    </div>
                    <div class="mb-3">
                        <label>Додати лабораторну до заняття</label>
                        <select id="lsLesson" name="lesson_id" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option selected></option>
                            @foreach($currentJournal->lessons as $lesson)
                            <option value="{{$lesson->id}}" data-date="{{$lesson->data_}}">{{$lesson->tema}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="maxval" class="form-label">Максимальна оцінка</label>
                        <select name="maxval" class="form-select form-select-md">
                            <option value="-2" selected>Зараховано</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Тип роботи</label>
                        <select id="typecontrol" name="control_type" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option value="11" selected>Лабораторна</option>
                            <option value="12">Практична</option>
                            <option value="13">Лабораторна фінал</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Зберегти</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="module">
    $(document).ready(function() {
        if ($('#dateAddControl').val() == "")
            $('#dateAddControl').val(new Date().toISOString().split('T')[0]);
        $('#lsLesson').change(function() {
            let datetime = $('#lsLesson  option:selected').data('date').split(' ')[0];
            $('#dateAddControl').val(datetime);
        });
    });
</script>