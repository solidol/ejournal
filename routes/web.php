<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsentController;
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
    return view('welc');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/journal', [UserController::class, 'listSubjects'])->name('get_subjects');

    //Route::get('/journal/{subj}/{group}', [UserController::class, 'showJournal'])->name('get_journal');

    Route::get('/journal/{subj}/{group}/marks', [MarkController::class, 'list'])->name('get_marks');

    Route::get('/journal/{subj}/{group}/lessons', [LessonController::class, 'list'])->name('get_lessons');

    Route::post('/journal/lessons/store', [LessonController::class, 'create'])->name('create_lesson');

    Route::post('/journal/lesson/update', [LessonController::class, 'update'])->name('update_lesson');

    Route::get('/journal/lesson:{lessonId}/more', [LessonController::class, 'show'])->name('show_lesson');

    Route::get('/journal/lesson:{lessonId}/edit', [LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/journal/lesson:{lessonId}/delete', [LessonController::class, 'destroy'])->name('delete_lesson');

    Route::post('/journal/marks/store', [MarkController::class, 'store'])->name('store_marks');

    Route::post('/journal/marks/create-control', [MarkController::class, 'createControl'])->name('create_control');

    Route::get('/journal/marks/{subj}/{group}/{control}/del-control', [MarkController::class, 'deleteControl'])->name('delete_control');

    Route::get('/ajax/marks/{subj}/{group}/{control}/info', [MarkController::class, 'apiIndex'])->name('get_info_control');

    Route::post('/journal/marks/control/update', [MarkController::class, 'updateControl'])->name('update_info_control');

    Route::get('/my/table', [LessonController::class, 'getTable'])->name('my_table');

    Route::get('/my/table/{year}/{month}', [LessonController::class, 'getTableDate'])->name('my_table_date');

    Route::post('/journal/absents/store', [AbsentController::class, 'store'])->name('store_absents');

    //    Route::get('/journal/absents/{date}/{subj}/{group}/{lesson}', [AbsentController::class, 'listAbsents'])->name('get_absents');


    Route::get('/my/profile', [UserController::class, 'show'])->name('show_profile');

    Route::get('/admin/another-user', [UserController::class, 'anotherLoginForm'])->name('admin_another_login');

    Route::get('/admin/user/list', [UserController::class, 'index'])->name('admin_userlist');

    Route::post('/admin/user/create', [UserController::class, 'store'])->name('admin_create_user');

    Route::post('/admin/another/login', [UserController::class, 'anotherLogin'])->name('admin_another_auth');
});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
