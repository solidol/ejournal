@extends('layouts.app')

@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
    <h2>Створити повідомлення</h2>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form method="POST" action="{{ route('message_send') }}">
                @csrf
                <div class="mb-3">
                    <label>Тип повідомлення</label>
                    <select id="cl" name="message_type" class="form-select form-select-md" aria-label=".form-select-sm example">
                        <option selected></option>
                        <option value="changelog">Історія версій</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="created_at" class="form-label">Дата повідомлення</label>
                    <input type="date" class="form-control" id="created_at" name="created_at">
                </div>

                <div class="mb-3">
                    <label for="maxval" class="form-label">Текст</label>
                    <textarea id="content" name="content" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Отримувач</label>
                    <select id="to_id" name="to_id" class="form-select form-select-md" aria-label=".form-select-sm example">
                        <option value="0" selected>Всі</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Зберегти</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection