<!-- Modal -->
<form action="{{$createControlRoute}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="addControl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Додати контроль</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="grcode" value="{{$data['group']}}">
                    <input type="hidden" name="sbjcode" value="{{$data['subj']}}">

                    <div class="mb-3">
                        <label for="control" class="form-label">Назва контролю</label>
                        <input type="text" class="form-control" id="control" name="control" placeholder="Опитування 0">
                    </div>
                    <div class="mb-3">
                        <label for="datetime1" class="form-label">Дата проведення</label>
                        <input type="date" class="form-control" id="datetime1" name="datetime1">
                    </div>
                    <div class="mb-3">
                        <label>Швидкі шаблони</label>
                        <select id="ftemp" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option selected></option>
                            <option >Опитування</option>
                            <option >Опитування 1</option>
                            <option >Опитування 2</option>
                            <option >Опитування 3</option>
                            <option >Опитування 4</option>
                            <option >Опитування 5</option>
                            <option >Опитування 6</option>
                            <option >Самостійна робота</option>
                            <option >МК 1</option>
                            <option >СМ 1</option>
                            <option >МК 2</option>
                            <option >СМ 2</option>
                            <option >МК 3</option>
                            <option >СМ 3</option>
                            <option >МК 4</option>
                            <option >СМ 4</option>
                            <option >ЛР</option>
                            <option >Підсумок</option>
                            <option >Екзамен</option>

                        </select>


                    </div>
                    <div class="mb-3">
                        <label for="maxval" class="form-label">Максимальна оцінка</label>
                        <input type="text" class="form-control" id="maxval" name="maxval" placeholder="30">
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

<script>
    //document.getElementById('datetime').valueAsDate = new Date();



    $(document).ready(function() {
        $('#ftemp').change(function() {
            $('#control').val($("#ftemp option:selected").text());
        });

        $('#datetime1').val(new Date().toISOString().split('T')[0]);
        //$('#example').DataTable();
    });
</script>