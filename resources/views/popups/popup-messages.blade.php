@if (session()->has('message'))
<div class="alert alert-success position-fixed  top-2 start-50 translate-middle" style="z-index: 11">
    <strong>{{ session('message') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger position-fixed  top-2 start-50 translate-middle" style="z-index: 11">
    <strong>{{ session('error') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

@if (session()->has('warning'))
<div class="alert alert-warning position-fixed  top-2 start-50 translate-middle" style="z-index: 11">
    <strong>{{ session('warning') }}</strong>

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@endif

<script type="module">
    $(document).ready(function() {
        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
    });
</script>