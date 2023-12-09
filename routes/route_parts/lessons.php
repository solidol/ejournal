<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MarkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;



Route::group(['middleware' => 'teacher'], function () {

    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

    Route::post('/lessons/store', [LessonController::class, 'store'])->name('lessons.store');

    Route::get('/journals/{id}/lessons', [LessonController::class, 'index'])->name('lessons.index');

    Route::post('/lessons/{lesson}/update', [LessonController::class, 'update'])->name('lessons.update');

    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');

    Route::get('/lessons/{lesson}/delete', [LessonController::class, 'destroy'])->name('lessons.delete');

});

Route::get('/api/lessons/{lesson}/ckeckin-link', [LessonController::class, 'checkinLink'])->name('lessons.nowlink.ajax');
