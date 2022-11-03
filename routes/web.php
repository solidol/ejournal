<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
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
    //Route::get('/journal', function(){ 
    //    return redirect()->route('get_subjects',['prep'=>Auth::user()->usercode]);
    //});
/*
    Route::get('/journal/{prep}', [UserController::class, 'listSubjects'])->name('get_subjects');

    Route::get('/journal/{prep}/{subj}/{group}', [UserController::class, 'showJournal'])->name('get_journal');

    Route::get('/journal/{prep}/{subj}/{group}/marks', [MarksController::class, 'list'])->name('get_marks');

    Route::get('/journal/{prep}/{subj}/{group}/lessons', [LessonController::class, 'list'])->name('get_lessons');

    Route::post('/journal/{prep}/{subj}/{group}/lessons/create', [LessonController::class, 'create'])->name('create_lesson');

    Route::post('/journal/lesson:{lessId}/update', [LessonController::class, 'update'])->name('update_lesson');

    Route::get('/journal/lesson:{lessId}/edit',[LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/journal/lesson:{lessId}/delete',[LessonController::class, 'destroy'])->name('delete_lesson');
    */
    Route::get('/journal', [UserController::class, 'listSubjects'])->name('get_subjects');

    //Route::get('/journal/{subj}/{group}', [UserController::class, 'showJournal'])->name('get_journal');

    Route::get('/journal/{subj}/{group}/marks', [MarkController::class, 'list'])->name('get_marks');

    Route::get('/journal/{subj}/{group}/lessons', [LessonController::class, 'list'])->name('get_lessons');

    Route::post('/journal/{subj}/{group}/lessons/create', [LessonController::class, 'create'])->name('create_lesson');

    Route::post('/journal/lesson/update', [LessonController::class, 'update'])->name('update_lesson');

    Route::get('/journal/lesson:{lessId}/edit',[LessonController::class, 'edit'])->name('edit_lesson');

    Route::get('/journal/lesson:{lessId}/delete',[LessonController::class, 'destroy'])->name('delete_lesson'); 
    
    Route::post('/journal/marks/store', [MarkController::class, 'store'])->name('store_marks');

    Route::post('/journal/marks/create-control', [MarkController::class, 'createControl'])->name('create_control');

    Route::get('/journal/marks/{subj}/{group}/{control}/del-control', [MarkController::class, 'deleteControl'])->name('delete_control');
});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);

