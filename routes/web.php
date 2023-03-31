<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AbsentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\TimesheetController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) return redirect()->route('home');
    else return view('welc');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');


    Route::post('/messages/send', [MessageController::class, 'send'])->name('message_send');



    Route::group(['middleware' => ['admin', 'student', 'teacher']], function () {
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin/users/login-as', [UserController::class, 'anotherLoginForm'])->name('admin_another_login');

        Route::post('/admin/users/login-as', [UserController::class, 'anotherLogin'])->name('admin_another_auth');

        Route::get('/admin/users/list', [UserController::class, 'index'])->name('admin_userlist');

        Route::post('/admin/users/create', [UserController::class, 'WUStore'])->name('admin_create_user');

        Route::get('/admin/log/list', [LogController::class, 'index'])->name('admin_loglist');

        Route::get('/admin/message/create', [MessageController::class, 'createAdmin'])->name('admin_message_create');
    });

    Route::group(['middleware' => 'student'], function () {
        Route::get('/student/journals/{id}/show/marks', [JournalController::class, 'studentMarks'])->name('student_get_marks');

        Route::get('/student/journals', [JournalController::class, 'studentMarks'])->name('student_get_journals');

        Route::get('/student/absents/{year?}/{month?}', [AbsentController::class, 'studentTable'])->name('student_get_absents');
    });


    Route::group(['middleware' => 'curator'], function () {
        Route::get('/curator/journals/{id}/show/marks', [JournalController::class, 'curatorMarks'])->name('curator_get_marks');

        Route::get('/curator/journals', [UserController::class, 'curatorGroups'])->name('curator_get_journals');
    });


    Route::group(['middleware' => 'teacher'], function () {
        // Пошук

        Route::get('/students/search', [StudentController::class, 'find'])->name('find_student');

        // Пари

        Route::get('/journals/{group?}', [JournalController::class, 'list'])->name('get_journals');

        Route::get('/journals/show/{id}', [JournalController::class, 'show'])->name('show_journal');

        Route::get('/journals/show/{id}/marks', [JournalController::class, 'marks'])->name('get_marks');

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

        Route::get('/users/profile', [UserController::class, 'show'])->name('show_profile');

        Route::get('/users/messages', [MessageController::class, 'list'])->name('list_messages');
    });
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
