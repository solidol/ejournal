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

    Route::match(array('GET', 'POST'), '/students/search', [StudentController::class, 'find'])->name('find_student');



    // Оцінки

    Route::post('/controls/{id}/marks/store', [MarkController::class, 'store'])->name('store_marks');

    Route::post('/controls/store', [ControlController::class, 'store'])->name('store_control');

    Route::get('/controls/delete/{id}', [ControlController::class, 'delete'])->name('delete_control');

    Route::post('/controls/update', [ControlController::class, 'update'])->name('update_info_control');

    Route::get('/ajax/controls/{id}/info', [ControlController::class, 'apiShow'])->name('get_info_control');



    Route::post('/files/examrep', [ReportController::class, 'getExamReport'])->name('get_exam_report');



    //    Табель

    Route::get('/my/timesheet/{year?}/{month?}', [TimesheetController::class, 'show'])->name('my.timesheet');
    Route::get('/my/calendar/{year?}/{month?}', [CalendarController::class, 'show'])->name('my.calendar');

    // Відсутні

    Route::post('/absents/lesson/{id}/store', [AbsentController::class, 'store'])->name('store_absents');


    // Повідомлення

    Route::get('/messages/index', [MessageController::class, 'list'])->name('message_index');

    Route::post('/messages/send-system', [MessageController::class, 'sendSystem'])->name('message_send_system');

    Route::post('/messages/share-lesson', [MessageController::class, 'shareLesson'])->name('message_share_lesson');

    Route::get('/messages/lesson/accept/{messId}', [MessageController::class, 'acceptLesson'])->name('message_accept_lesson');

    Route::get('/messages/delete/{messId}', [MessageController::class, 'deleteLesson'])->name('message_delete');


    // Профіль

    Route::get('/users/messages', [MessageController::class, 'list'])->name('list_messages');

  });
