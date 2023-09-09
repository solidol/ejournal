<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;

Route::group(['middleware' => 'admin'], function () {
        Route::get('/teacher', function () {
            Session::put('localrole', 'teacher');
            return redirect()->route('home');
        });

        Route::get('/admin/events', [LogController::class, 'index'])->name('logs.index');

        Route::get('/admin/message/create', [MessageController::class, 'createAdmin'])->name('admin_message_create');

        Route::post('/tokens/create', function (Request $request) {
            $token = $request->user()->createToken($request->token_name);
        
            return ['token' => $token->plainTextToken];
        });
    });

?>