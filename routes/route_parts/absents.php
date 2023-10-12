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
use App\Http\Controllers\CalendarController;


Route::group(['middleware' => 'teacher'], function () {
  
    // Відсутні

    Route::post('/absents/lesson/{id}/store', [AbsentController::class, 'store'])->name('absents.store');


  });
