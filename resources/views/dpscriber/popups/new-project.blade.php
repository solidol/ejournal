<!-- Modal -->
<form action="{{URL::route('diploma_project_store')}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Додати проект</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="projecting_id" value="{{$currentProjecting->id}}">

                    <div class="mb-3">
                        <label for="control" class="form-label">Тема</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label>Студент</label>
                        <select name="student_id" class="form-select form-select-md" required>
                            @foreach ($students as $sItem)
                            <option value="{{$sItem->id}}">{{$sItem->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Керівник</label>
                        <select name="teacher_id" class="form-select form-select-md" required>
                            @foreach ($teachers as $tItem)
                            <option value="{{$tItem->id}}">{{$tItem->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="datetAddControl" class="form-label">Дата захисту</label>
                        <input type="date" class="form-control" name="reporting_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="maxval" class="form-label">Номер дня та порядок захисту</label>
                        <input type="text" class="form-control" id="maxval" name="prot_nummber" >
                    
                        <input type="text" class="form-control" id="maxval" name="prot_subnumber" >
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

</script>