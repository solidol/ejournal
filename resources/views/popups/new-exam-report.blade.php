<!-- Modal -->
<form action="{{URL::route('get_exam_report')}}" method="post">
    @csrf
    <!-- {{ csrf_field() }} -->
    <div class="modal fade" id="addExamReport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Створити екзаменаційну відомість</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Контроль</label>
                        <select id="control_id" name="control_id" class="form-select form-select-md">
                            <option value="-1" selected>Оберіть контроль</option>
                            @foreach ($currentJournal->controls as $cItem)
                            <option value="{{$cItem->id}}">{{$cItem->date_?$cItem->date_->format('d.m.Y'):'Без дати'}} {{$cItem->title}}</option>
                            @endforeach
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

</script>