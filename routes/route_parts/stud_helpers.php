<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/student/rnd', [StudentController::class, 'rnd'])->name('students.rnd');
});