<!-- Modal -->
<form action="{{URL::route('additionals.store')}}" method="post">
    @csrf
    <div class="modal fade" id="addAdditional" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Додати матеріал до роботи</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="additionable_id" value="{{$currentControl->id}}">

                    <input type="hidden" name="additionable_type" value="App\Models\Practice">

                    <div class="mb-3">
                        <label for="control" class="form-label">Назва</label>
                        <input type="text" class="form-control" id="control" name="title" placeholder="Введіть тему" required>
                    </div>
                    <div class="mb-3">
                        <label>Тип матеріалу</label>
                        <select id="additional_type" name="additional_type" class="form-select form-select-md" aria-label=".form-select-sm example">
                            <option value="100" selected>Звичайне посилання</option>
                            <option value="101">Youtube-посилання</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="zadanaie">Короткий опис</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="control" class="form-label">Посилання</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Введіть тему" required>
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