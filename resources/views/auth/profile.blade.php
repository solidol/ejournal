@extends('layouts.app-simple')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header  text-white bg-dark">Мій профіль</div>

                <div class="card-body row">
                    <div class="col-4">
                        @if (Auth::user()->isTeacher())
                        <img class="w-100" src="{{route('teacher.avatar.get',['id'=>Auth::user()->userable->id])}}">
                        @endif
                        <form action="/tokens/create" method="post">
                            @csrf
                            <input type="hidden" name="token_name" value="test">
                            <button type="submit">create</button>
                        </form>
                    </div>
                    <div class="col-8">

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