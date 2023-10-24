<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\PracticeController;



Route::group(['middleware' => 'teacher'], function () {


    // Оцінки
    Route::get('/journals/{id}/practices', [PracticeController::class, 'index'])->name('practices.index');

    Route::get('/practices/{practice}', [PracticeController::class, 'show'])->name('practices.show');

    Route::post('/practices/{practice}/marks/store', [MarkController::class, 'storePractice'])->name('practices.marks.store');

    Route::post('/practices/store', [PracticeController::class, 'store'])->name('practices.store');

    Route::get('/practices/{practice}/delete', [PracticeController::class, 'destroy'])->name('practices.delete');

    Route::post('/practices/update', [PracticeController::class, 'update'])->name('practices.update');


  });
