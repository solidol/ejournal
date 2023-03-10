<!-- Modal -->
<form action="{{URL::route('update_info_control')}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="editControl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Редагувати контроль</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="control_id" name="control_id" value="">

                    <div class="mb-3">
                        <label for="control1" class="form-label">Назва контролю</label>
                        <input type="text" class="form-control" id="control1" name="title" placeholder="Опитування 0">
                    </div>
                    <div class="mb-3">
                        <label for="datetime2" class="form-label">Дата проведення</label>
                        <input type="date" class="form-control" id="datetime2" name="edited_date">
                    </div>
                    <div class="mb-3">
                        <label>Швидкі шаблони</label>
                        <select id="ftemp1" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option selected></option>
                            <option>Опитування</option>
                            <option>Опитування 1</option>
                            <option>Опитування 2</option>
                            <option>Опитування 3</option>
                            <option>Опитування 4</option>
                            <option>Опитування 5</option>
                            <option>Опитування 6</option>
                            <option>Самостійна робота</option>
                            <option>МК 1</option>
                            <option>СМ 1</option>
                            <option>МК 2</option>
                            <option>СМ 2</option>
                            <option>МК 3</option>
                            <option>СМ 3</option>
                            <option>МК 4</option>
                            <option>СМ 4</option>
                            <option>ЛР</option>
                            <option>Підсумок</option>
                            <option>Екзамен</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="maxval1" class="form-label">Максимальна оцінка</label>
                        <input type="text" class="form-control" id="maxval1" name="max_grade" placeholder="30">
                    </div>
                    <div class="mb-3">
                        <label>Тип контроля</label>
                        <select id="typecontrol1" name="typecontrol" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option value="0" selected>Поточний (Опитування, ЛР, СР, Практичні, тощо)</option>
                            <option value="1">Модульний (Модульні та тематичні контролі)</option>
                            <option value="2">Підсумковий (Рубіжний, Семестровий, Підсумок, Іспит, Річна)</option>
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

        $('#updateControl').click(function() {

        });

        $('.edit-control').click(function() {
            let url = $(this).data('url');
            console.log(url);
            $.get(url, function(data, status) {
                $('#control_id').val(data.id);
                $('#datetime2').val((data.date_).split('T')[0]);
                $('#control1').val(data.title);
                $('#maxval1').val(data.max_grade);
                $("typecontrol1 option[value=" + data.type_ + "]").attr('selected', 'true');
            });
        });

        $('#ftemp1').change(function() {
            $('#control1').val($("#ftemp1 option:selected").text());
        });

    });
</script>