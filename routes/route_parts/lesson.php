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

    Route::post('/lessons/store', [LessonController::class, 'store'])->name('store_lesson');

    Route::get('/journals/{id}/lessons', [LessonController::class, 'index'])->name('lessons.index');

    Route::post('/lessons/{id}/update', [LessonController::class, 'update'])->name('lessons.update');

    Route::get('/lessons/{id}/show', [LessonController::class, 'show'])->name('show_lesson');

    Route::get('/lessons/{id}/edit', [LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/lessons/{id}/delete', [LessonController::class, 'destroy'])->name('delete_lesson');

    Route::get('/ajax/lessons/lessons/{id}', [LessonController::class, 'apiShow'])->name('get_info_lesson');
});
