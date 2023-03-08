@extends('layouts.app-nosidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Вітаємо! Ви авторизовані. Перейдіть у потрібний розділ у головному меню.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
