@extends('layouts.app')

@section('sidebar')
<div class="baloon">
    <h1>Адмінпанель</h1>
    <h2>Увійти від імені</h2>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-1">
                <div class="card-header text-white bg-dblue">Вхід у журнал</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin_another_auth') }}">
                        @csrf

                        <div class="form-group row mb-2">
                            <label for="sel" class="col-md-4 col-form-label text-md-right">Оберіть користувача</label>

                            <div class="col-md-6">
                                <select class="form-select" name="userid" size="20" aria-label="size 3 select example">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mb-2">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Увійти
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection