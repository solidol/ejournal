<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AbsentController;



Route::group(['middleware' => 'teacher'], function () {
  
    // Відсутні

    Route::post('/absents/lesson/{id}/store', [AbsentController::class, 'store'])->name('absents.store');


  });
