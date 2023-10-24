<!-- Modal -->
<form action="{{URL::route('practices.update')}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="editControl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Редагувати лабораторну</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="control_id" name="control_id" value="">

                    <div class="mb-3">
                        <label for="control1" class="form-label">Тема лабораторної (практичної)</label>
                        <input type="text" class="form-control" id="control1" name="title" placeholder="Опитування 0">
                    </div>
                    <div class="mb-3">
                        <label for="datetime2" class="form-label">Дата проведення</label>
                        <input type="date" class="form-control" id="datetime2" name="edited_date">
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
                        <label>Тип контроля</label>
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
        $('.edit-control').click(function() {
            let url = $(this).data('url');
            console.log(url);
            $.get(url, function(data, status) {
                $('#control_id').val(data.id);
                $('#datetime2').val((data.date_).split('T')[0]);
                $('#control1').val(data.title);
                $('#maxval1').val(data.max_grade);
                $("#typecontrol1 option").removeAttr('selected');
                $("#typecontrol1 option[value=" + data.type_ + "]").attr('selected', 'true');
            });
        });

        $('#ftemp1').change(function() {
            $('#control1').val($("#ftemp1 option:selected").text());
        });

    });
</script>