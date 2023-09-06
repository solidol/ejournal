<div class="modal fade" id="viewLesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white bg-dark">
                <h5 class="modal-title" id="exampleModalLabel">Швидкий перегляд</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h2 id="lsTheme"></h2>
                <p id="lsDate"></p>
                <p id="lsNumber"></p>
                <p id="lsHomeWork"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.show-lesson').click(function() {
            let url = $(this).data('url');
            console.log(url);
            $.get(url, function(data, status) {

                $('#lsTheme').text(data.tema);
                $('#lsDate').text(data.date_formatted);
                $('#lsHomeWork').text(data.zadanaie);

            });
        });
    });
</script>