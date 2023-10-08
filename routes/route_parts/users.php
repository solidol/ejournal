<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;

Route::group(['middleware' => 'admin'], function () {

        Route::get('/users/{slug?}', [UserController::class, 'index'])->name('users.index');

        Route::post('/users', [UserController::class, 'WUStore'])->name('users.store');

        Route::get('/users/loginas/{user}', [UserController::class, 'loginAs'])->name('users.loginas');
    });

?>