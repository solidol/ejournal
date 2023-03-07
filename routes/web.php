<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ControlController;
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
    if (Auth::user()) return redirect()->route('get_journals');
    else return view('welc');
});

Route::group(['middleware' => 'auth'], function () {

    // Журнал та пари

    Route::get('/journals', [JournalController::class, 'list'])->name('get_journals');

    //Route::get('/journal/{subj}/{group}', [UserController::class, 'showJournal'])->name('get_journal');

    Route::get('/journals/show:{id}', [JournalController::class, 'show'])->name('show_journal');

    Route::get('/journals/show:{id}/marks', [JournalController::class, 'marks'])->name('get_marks');

    //Route::get('/journals/show:{id}/lessons', [LessonController::class, 'list'])->name('get_lessons');

    Route::post('/journals/store', [JournalController::class, 'store'])->name('store_journal');

    Route::post('/lessons/store', [LessonController::class, 'store'])->name('store_lesson');

    Route::post('/lesson/update', [LessonController::class, 'update'])->name('update_lesson');

    Route::get('/lessons/show:{id}', [LessonController::class, 'show'])->name('show_lesson');

    Route::get('/lessons/edit:{id}', [LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/lessons/delete:{id}', [LessonController::class, 'destroy'])->name('delete_lesson');


    // Журнал та оцінки

    Route::post('/marks/store', [MarkController::class, 'store'])->name('store_marks');

    Route::post('/marks/control/store', [ControlController::class, 'store'])->name('store_control');

    Route::get('/marks/control:{id}/delete', [ControlController::class, 'delete'])->name('delete_control');

    Route::post('/marks/control:{id}/update', [ControlController::class, 'update'])->name('update_info_control');

    Route::get('/ajax/marks/control:{id}/info', [ControlController::class, 'apiShow'])->name('get_info_control');

    //    Табель

    Route::get('/my/table', [LessonController::class, 'getTable'])->name('my_table');

    Route::get('/my/table/{year}/{month}', [LessonController::class, 'getTableDate'])->name('my_table_date');

    // журнал та ідсутні

    Route::post('/journal/absents/store', [AbsentController::class, 'store'])->name('store_absents');

    //    Route::get('/journal/absents/{date}/{subj}/{group}/{lesson}', [AbsentController::class, 'listAbsents'])->name('get_absents');


    // Повідомлення

    Route::get('/messages/index', [MessageController::class, 'list'])->name('message_index');

    Route::post('/messages/send', [MessageController::class, 'send'])->name('message_send');

    Route::post('/messages/send-system', [MessageController::class, 'sendSystem'])->name('message_send_system');

    Route::post('/messages/share-lesson', [MessageController::class, 'shareLesson'])->name('message_share_lesson');

    Route::get('/messages/lesson/accept/{messId}',[MessageController::class, 'acceptLesson'])->name('message_accept_lesson');

    Route::get('/messages/delete/{messId}',[MessageController::class, 'deleteLesson'])->name('message_delete');


    // Профіль

    Route::get('/my/profile', [UserController::class, 'show'])->name('show_profile');

    Route::get('/my/messages', [MessageController::class, 'list'])->name('list_messages');



    // Адмінпанель

    Route::get('/admin/user/login-as', [UserController::class, 'anotherLoginForm'])->name('admin_another_login');

    Route::post('/admin/user/login-as', [UserController::class, 'anotherLogin'])->name('admin_another_auth');

    Route::get('/admin/user/list', [UserController::class, 'index'])->name('admin_userlist');

    Route::post('/admin/user/create', [UserController::class, 'WUStore'])->name('admin_create_user');

    Route::get('/admin/log/list', [LogController::class, 'index'])->name('admin_loglist');

});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
