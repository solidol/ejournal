<?php


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DiplomaProjectingController;
use App\Http\Controllers\DiplomaProjectController;
use App\Http\Controllers\ReportController;



Route::group(['middleware' => 'dpscriber'], function () {
  // Diploma

  Route::get('/dp/projecting/index', [DiplomaProjectingController::class, 'index'])->name('diploma_projectings_index');

  Route::get('/dp/projecting/{id}', [DiplomaProjectingController::class, 'show'])->name('diploma_projectings_show');

  Route::post('/dp/projecting/{id}/update', [DiplomaProjectingController::class, 'update'])->name('diploma_projectings_update');

  Route::post('/dp/projecting/store', [DiplomaProjectingController::class, 'store'])->name('diploma_projectings_store');

  Route::post('/dp/projecting/project/store', [DiplomaProjectController::class, 'store'])->name('diploma_project_store');

  Route::post('/dp/projecting/project/{id}/update', [DiplomaProjectController::class, 'update'])->name('diploma_project_update');

  Route::get('/dp/projecting/project/{id}/delete', [DiplomaProjectController::class, 'delete'])->name('diploma_project_delete');

  Route::get('/dp/projecting/project/{id}/show', [DiplomaProjectController::class, 'show'])->name('diploma_project_show');

  Route::get('/dp/projecting/project/{id}/prot', [ReportController::class, 'getProtoReport'])->name('diploma_project_prot');

});