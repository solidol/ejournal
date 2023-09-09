<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\MessageController;

use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MDBController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) return redirect()->route('home');
    else return view('welc');
});

require_once __DIR__ . '/route_parts/admin.php';

require_once __DIR__ . '/route_parts/student.php';

require_once __DIR__ . '/route_parts/curator.php';

require_once __DIR__ . '/route_parts/teacher.php';

require_once __DIR__ . '/route_parts/lessons.php';

require_once __DIR__ . '/route_parts/journals.php';

require_once __DIR__ . '/route_parts/controls.php';

require_once __DIR__ . '/route_parts/dpscriber.php';

require_once __DIR__ . '/route_parts/mdb.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/files/teachers/{id}.jpg', [TeacherController::class, 'avatar'])->name('teacher.avatar.get');

    Route::post('/messages/send', [MessageController::class, 'send'])->name('message_send');

    Route::get('/users/profile', [UserController::class, 'show'])->name('show_profile');

    Route::group(['middleware' => ['admin', 'student', 'teacher']], function () {
    });
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
