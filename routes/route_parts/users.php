<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;

Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin/users/login-as', [UserController::class, 'loginAsForm'])->name('users.loginas.form');

        Route::post('/admin/users/login-as', [UserController::class, 'loginAs'])->name('users.loginas.post');

        Route::get('/admin/users/list/{slug?}', [UserController::class, 'index'])->name('users.index');

        Route::post('/admin/users/store', [UserController::class, 'WUStore'])->name('users.store');

        
    });

?>