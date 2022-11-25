@extends('layouts.app')

@section('sidebar')
<h1>Адмінпанель</h1>
<h2>Користувачі</h2>
@endsection

@section('content')

@csrf
<h2>Користувачі web-інтерфейсу</h2>
<table class="table table-stripped table-bordered">
    <thead>
        <tr>
            <th>
                Ім'я
            </th>
            <th>
                email
            </th>
            <th>
                Роль
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->usertype}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection