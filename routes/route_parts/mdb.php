<?php

use App\Http\Controllers\MDBController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/mdb', [MDBController::class, 'index'])->name('mdb.index');

    Route::get('/mdb/download', [MDBController::class, 'download'])->name('mdb.download');
});
