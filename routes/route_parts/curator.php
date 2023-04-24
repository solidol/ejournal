<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;

use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'curator'], function () {
    Route::get('/teacher', function () {
        Session::put('localrole', 'teacher');
        return redirect()->route('home');
    });

    Route::get('/curator/journals/{id}/show/marks', [JournalController::class, 'curatorMarks'])->name('curator_get_marks');

    Route::get('/curator/journals', [UserController::class, 'curatorGroups'])->name('curator_get_journals');
});