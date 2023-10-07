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
    Route::get('/teacher', function () {
        Session::put('localrole', 'teacher');
        return redirect()->route('home');
    });
    Route::get('/curator', function () {
        Session::put('localrole', 'curator');
        return redirect()->route('home');
    });

    Route::get('/admin', function () {
        Session::put('localrole', 'admin');
        return redirect()->route('home');
    });

    // Пошук

    Route::match(array('GET', 'POST'), '/students', [StudentController::class, 'index'])->name('students.index');


    Route::post('/files/examrep', [ReportController::class, 'getExamReport'])->name('get_exam_report');



    //    Табель

    Route::get('/my/timesheet/{year?}/{month?}', [TimesheetController::class, 'show'])->name('my.timesheet');
    Route::get('/my/calendar/{year?}/{month?}', [CalendarController::class, 'show'])->name('my.calendar');

    // Відсутні

    Route::post('/absents/lesson/{id}/store', [AbsentController::class, 'store'])->name('store_absents');


    // Повідомлення

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    
    Route::get('/messages/delete/{message}', [MessageController::class, 'destroy'])->name('messages.delete');
  });
