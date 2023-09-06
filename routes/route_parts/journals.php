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

    // Пари

    Route::get('/journals/{group?}', [JournalController::class, 'index'])->name('journals.index');

    Route::get('/journals/{journal}/show', [JournalController::class, 'show'])->name('journals.show');



    Route::get('/journals/{id}/marks', [JournalController::class, 'marks'])->name('get_marks');

    Route::get('/journals/show/{journal_id}/control/{control_id}', [ControlController::class, 'show'])->name('controls.show');

    Route::post('/journals/store', [JournalController::class, 'store'])->name('journals.store');


    Route::post('/journals/{journal}/lessons', [JournalController::class, 'update'])->name('journals.update');


});
