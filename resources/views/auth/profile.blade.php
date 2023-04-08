@extends('layouts.app-nosidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-1">
                <div class="card-header text-white bg-dblue">Перегляд профілю</div>

                <div class="card-body">


                        <div class="form-group row mb-2">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Ім'я</label>

                            <div class="col-md-6">
                                {{ $user->userable->fullname }}
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Логін</label>

                            <div class="col-md-6">
                                {{ $user->name }}
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection