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


    // Повідомлення

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/messages/delete/{message}', [MessageController::class, 'destroy'])->name('messages.delete');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/message/create/sys', [MessageController::class, 'createAdmin'])->name('messages.create_sys');
});
