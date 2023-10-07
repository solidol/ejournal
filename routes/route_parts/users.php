<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;

Route::group(['middleware' => 'admin'], function () {

        Route::get('/admin/users/list/{slug?}', [UserController::class, 'index'])->name('users.index');

        Route::post('/admin/users/store', [UserController::class, 'WUStore'])->name('users.store');

        Route::get('/admin/users/loginas/{user}', [UserController::class, 'loginAs'])->name('users.loginas');
    });

?>