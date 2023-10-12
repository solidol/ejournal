<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PresentController;
use App\Http\Controllers\AbsentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\GroupController;



Route::group(['middleware' => 'student'], function () {
    Route::get('/student/journals/{id}/show/marks', [JournalController::class, 'studentMarks'])->name('student_get_marks');

    Route::get('/student/journals', [JournalController::class, 'studentMarks'])->name('student_get_journals');

    Route::post('/student/lessons/{lesson}', [PresentController::class, 'store'])->name('lessons.present.store');

    Route::get('/student/lessons/{lesson}', [LessonController::class, 'now'])->name('lessons.now.show');

    Route::get('/student/absents/{year?}/{month?}', [AbsentController::class, 'studentTable'])->name('student_get_absents');

    Route::get('/student/teachers', [GroupController::class, 'studentTeachers'])->name('student_get_teachers');

    Route::get('/student/absents/{year?}/{month?}', [AbsentController::class, 'studentTable'])->name('student_get_absents');
});