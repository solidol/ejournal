<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CuratorController;
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

    Route::get('/curator/local/students/list/{group_id?}', [CuratorController::class, 'studList'])->name('corator_local_student_list');

    Route::get('/curator/local/students/{id}/profile', [CuratorController::class, 'profile'])->name('corator_local_student_profile');

    Route::get('/curator/local/students/{id}/absents/{year?}/{month?}', [CuratorController::class, 'absents'])->name('curator_local_student_absents');

    Route::get('/curator/local/students/{id}/marks/{journal_id?}', [CuratorController::class, 'marks'])->name('corator_local_student_marks');
});
