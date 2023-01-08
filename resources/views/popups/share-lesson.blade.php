<form action="{{URL::route('message_share_lesson')}}" method="post">
    @csrf
    <div class="modal fade" id="shareLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dblue">
                    <h5 class="modal-title" id="exampleModalLabel">Поділитися парою</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="lesscode" value="{{$lesson->kod_pari}}">

                    <div class="mb-3">
                        <label>Оберіть користувача</label>
                        <select id="user_id" name="user_id" class="form-select form-select-md" 
                        aria-label=".form-select-sm example" required placeholder="Оберіть групу">
                            <option selected></option>
                            @foreach ($arUsers as $user)
                            <option value="{{$user->id}}">{{$user->userable->FIO_prep}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Поширити</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-danger" id="freset">Очистити</button>

                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#freset').click(function() {

        });
    });
</script>