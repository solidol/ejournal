<!-- Modal -->
<form action="{{URL::route('store_journal')}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="addLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Записати першу пару</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="lesscode" value="-1">
                    <div class="mb-3">
                        <label>Оберіть дисципліну</label>
                        <select id="sbjcode" name="sbjcode" class="form-select form-select-md" aria-label=".form-select-sm example" required placeholder="Оберіть дисципліну">
                            <option selected></option>
                            @foreach ($sbjList as $sItem)
                            <option value="{{$sItem->kod_subj}}">{{$sItem->subject_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Оберіть групу</label>
                        <select id="grcode" name="grcode" class="form-select form-select-md" aria-label=".form-select-sm example" required placeholder="Оберіть групу">
                            <option selected></option>
                            @foreach ($grList as $gItem)
                            <option value="{{$gItem->kod_grup}}">{{$gItem->nomer_grup}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="datetime1" class="form-label">Коментар</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="datetime1" class="form-label">Дата</label>
                        <input type="date" class="form-control" id="datetime1" name="datetime">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Номер пари</label>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio1" value="1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">1</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio2" value="2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">2</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio3" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio3">3</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio4" value="4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio4">4</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio5" value="5" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio5">5</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio6" value="6" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio6">6</label>
                            <!--
                            <input type="radio" class="btn-check" name="lessnom" id="btnradio7" value="7" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio7">7</label>

                            <input type="radio" class="btn-check" name="lessnom" id="btnradio8" value="8" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio8">8</label>
-->
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Годин</label>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="hours" id="btnradio11" value="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio11">1</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio12" value="2" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio12">2</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio13" value="3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio13">3</label>

                            <input type="radio" class="btn-check" name="hours" id="btnradio14" value="4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio14">4</label>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="thesis" class="form-label">Тема</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="thesis" name="thesis" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="zadanaie">Що задано</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="homework" name="homework"></textarea>
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

<script type="module">
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

    });
</script>