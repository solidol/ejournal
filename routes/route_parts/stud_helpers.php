<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;


//Route::group(['middleware' => 'student'], function () {
    Route::get('/student/rnd', [StudentController::class, 'rnd'])->name('students.rnd');
//});