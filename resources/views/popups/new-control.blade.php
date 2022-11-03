


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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Зберегти</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-danger" id="freset">Очистити</button>

                </div>
            </div>
        </div>
    </div>
</form>

<script>
    //document.getElementById('datetime').valueAsDate = new Date();



    $(document).ready(function() {
        $('#freset').click(function() {
            $('#homework').val('');
            $('#thesis').val('');
        });
        $('#addlect').click(function() {
            $('#homework').val('Конспект');
        });
        $('#addrep').click(function() {
            $('#homework').val('Звіт');
        });
        $('#datetime1').val(new Date().toISOString().split('T')[0]);
        //$('#example').DataTable();
    });
</script>
