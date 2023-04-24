<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

Route::group(['middleware' => 'admin'], function () {
        Route::get('/teacher', function () {
            Session::put('localrole', 'teacher');
            return redirect()->route('home');
        });

        Route::get('/admin/users/login-as', [UserController::class, 'anotherLoginForm'])->name('admin_another_login');

        Route::post('/admin/users/login-as', [UserController::class, 'anotherLogin'])->name('admin_another_auth');

        Route::get('/admin/users/list/{slug?}', [UserController::class, 'index'])->name('admin_userlist');

        Route::post('/admin/users/create', [UserController::class, 'WUStore'])->name('admin_create_user');

        Route::get('/admin/log/list', [LogController::class, 'index'])->name('admin_loglist');

        Route::get('/admin/message/create', [MessageController::class, 'createAdmin'])->name('admin_message_create');
    });

?>