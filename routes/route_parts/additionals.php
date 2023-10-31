<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AdditionalController;



Route::group(['middleware' => 'teacher'], function () {
  
    // Відсутні

    Route::post('/additionals/store', [AdditionalController::class, 'store'])->name('additionals.store');

    Route::get('/additionals/{additional}/delete', [AdditionalController::class, 'destroy'])->name('additionals.delete');


  });
