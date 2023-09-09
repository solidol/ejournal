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


    // Оцінки
    Route::get('/journals/{id}/marks', [MarkController::class, 'index'])->name('marks.index');

    Route::get('/controls/{control}', [ControlController::class, 'show'])->name('controls.show');

    Route::post('/controls/{control}/marks/store', [MarkController::class, 'store'])->name('marks.store');

    Route::post('/controls/store', [ControlController::class, 'store'])->name('controls.store');

    Route::get('/controls/{control}/delete', [ControlController::class, 'destroy'])->name('controls.delete');

    Route::post('/controls/update', [ControlController::class, 'update'])->name('controls.update');

  });
