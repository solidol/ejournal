

<form action="{{URL::route('update_lesson')}}" method="post">
    @csrf
    <div class="modal fade" id="editLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-white bg-dblue">
                    <h5 class="modal-title" id="exampleModalLabel">Редагувати пару</h5>

                </div>
                <div class="modal-body">

                    <input type="hidden" name="lesscode" value="{{$lesson->kod_pari}}">
                    <input type="hidden" name="grcode" value="{{$lesson->kod_grupi}}">
                    <input type="hidden" name="sbjcode" value="{{$lesson->kod_subj}}">

                    <div class="mb-3">
                        <label for="datetime1" class="form-label">Дата</label>
                        <input type="date" class="form-control" id="datetime1" name="datetime" value="{{$lesson->data_}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Номер пари</label>
                        <input type="number" class="form-control" id="lessnom" name="lessnom" min="1" step="1" max="6" value="{{$lesson->nom_pari}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Години</label>
                        <input type="number" class="form-control" id="hours" name="hours" min="1" step="1" max="4" value="{{$lesson->kol_chasov}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="thesis" class="form-label">Тема</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="thesis" name="thesis" required>{{$lesson->tema}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="zadanaie">Що задано</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="homework" name="homework">{{$lesson->zadanaie}}</textarea>
                        <button id="addlect" type="button" class="btn btn-secondary">Конспект</button>
                        <button id="addrep" type="button" class="btn btn-secondary">Звіт</button>
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
        //$('#datetime1').val(new Date().toISOString().split('T')[0]);

    });
</script>