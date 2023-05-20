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
use App\Http\Controllers\MDBController;


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

    // Пари

    Route::get('/journals/{group?}', [JournalController::class, 'list'])->name('get_journals');

    Route::get('/journals/show/{id}', [JournalController::class, 'show'])->name('show_journal');

    Route::get('/journals/show/{id}/lessons', [JournalController::class, 'lessons'])->name('list_lessons');

    Route::get('/journals/show/{id}/marks', [JournalController::class, 'marks'])->name('get_marks');

    Route::get('/journals/show/{journal_id}/control/{control_id}', [ControlController::class, 'show'])->name('show_control');

    Route::post('/journals/store', [JournalController::class, 'store'])->name('store_journal');

    Route::post('/lessons/store', [LessonController::class, 'store'])->name('store_lesson');

    Route::post('/lessons/update', [LessonController::class, 'update'])->name('update_lesson');

    Route::get('/lessons/show/{id}', [LessonController::class, 'show'])->name('show_lesson');

    Route::get('/lessons/edit/{id}', [LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/lessons/delete/{id}', [LessonController::class, 'destroy'])->name('delete_lesson');

    Route::get('/ajax/lessons/lessons/{id}', [LessonController::class, 'apiShow'])->name('get_info_lesson');


    // Оцінки

    Route::post('/controls/{id}/marks/store', [MarkController::class, 'store'])->name('store_marks');

    Route::post('/controls/store', [ControlController::class, 'store'])->name('store_control');

    Route::get('/controls/delete/{id}', [ControlController::class, 'delete'])->name('delete_control');

    Route::post('/controls/update', [ControlController::class, 'update'])->name('update_info_control');

    Route::get('/ajax/controls/{id}/info', [ControlController::class, 'apiShow'])->name('get_info_control');



    Route::post('/files/examrep', [ControlController::class, 'getExamReport'])->name('get_exam_report');



    //    Табель

    //Route::get('/my/timesheet', [TimesheetController::class, 'getTimesheet'])->name('my_timesheet');

    Route::get('/my/timesheet/{year?}/{month?}', [TimesheetController::class, 'getTimesheetDate'])->name('my_timesheet_date');

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
