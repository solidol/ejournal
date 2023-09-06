<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AbsentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ReportController;
use App\http\Controllers\CalendarController;


Route::group(['middleware' => 'teacher'], function () {

    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

    Route::post('/lessons/store', [LessonController::class, 'store'])->name('lessons.store');

    Route::get('/journals/{id}/lessons', [LessonController::class, 'index'])->name('lessons.index');

    Route::post('/lessons/{lesson}/update', [LessonController::class, 'update'])->name('lessons.update');

    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');

    Route::get('/lessons/{lesson}/delete', [LessonController::class, 'destroy'])->name('lessons.delete');

});
