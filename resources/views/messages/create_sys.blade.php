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

            <form method="POST" action="{{ route('messages.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="created_at" class="form-label">Початок показу</label>
                    <input type="datetime-local" class="form-control" id="created_at" name="datetime_start">
                </div>

                <div class="mb-3">
                    <label for="created_at" class="form-label">Кінець показу</label>
                    <input type="datetime-local" class="form-control" id="created_at" name="datetime_end">
                </div>

                <div class="mb-3">
                    <label for="maxval" class="form-label">Текст</label>
                    <textarea id="content" name="content" class="form-control"></textarea>
                </div>
                <input type="hidden" name="from_id" value="0">
                <input type="hidden" name="message_type" value="text">
                <div class="mb-3">
                    <label>Отримувач</label>
                    <select id="to_id" name="to_id" class="form-select form-select-md" aria-label=".form-select-sm example">
                        <option value="0" selected>Всі</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->userable->fullname}}</option>
                        @endforeach
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