<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\MessageController;

use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LessonSheduleController;

use Laravel\Sanctum\PersonalAccessToken;
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
    if (Auth::user())
        return redirect()->route('home');
    else
        return view('welc');
});

require_once __DIR__ . '/route_parts/stud_helpers.php';

require_once __DIR__ . '/route_parts/admin.php';

require_once __DIR__ . '/route_parts/absents.php';

require_once __DIR__ . '/route_parts/events.php';

require_once __DIR__ . '/route_parts/users.php';

require_once __DIR__ . '/route_parts/student.php';

require_once __DIR__ . '/route_parts/curator.php';

require_once __DIR__ . '/route_parts/teacher.php';

require_once __DIR__ . '/route_parts/lessons.php';

require_once __DIR__ . '/route_parts/journals.php';

require_once __DIR__ . '/route_parts/controls.php';

require_once __DIR__ . '/route_parts/practices.php';

require_once __DIR__ . '/route_parts/additionals.php';

require_once __DIR__ . '/route_parts/marks.php';

require_once __DIR__ . '/route_parts/dpscriber.php';

require_once __DIR__ . '/route_parts/mdb.php';

require_once __DIR__ . '/route_parts/messages.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/tokens/create', function () {
        $token = Auth::user()->createToken('access-token')->plainTextToken;

        return response()->json(['access_token' => $token]);
    });



    Route::get('/files/teachers/{id}.jpg', [TeacherController::class, 'avatar'])->name('teacher.avatar.get');

    Route::post('/messages/send', [MessageController::class, 'send'])->name('message_send');

    Route::get('/users/profile/my', [UserController::class, 'myShow'])->name('my.profile');

    Route::group(['middleware' => ['admin', 'student', 'teacher']], function () {
    });
});

Route::get('/lessons/shedule/replacements:{count?}', [LessonSheduleController::class, 'replacements'])->name('lessons.shedule.replacements');
Route::get('/lessons/shedule/replacements/checkrep', [LessonSheduleController::class, 'checkrep'])->name('lessons.shedule.checkrep');

//Route::get('/lessons/shedule/group:{group}', [LessonSheduleController::class, 'group'])->name('lessons.shedule.group');


Route::post('/login/token:{hashedTooken}',function($hashedTooken){
    $token = PersonalAccessToken::findToken($hashedTooken);
    $user = $token->tokenable;
    Auth::loginUsingId($user->id);
    return redirect('/home');
});

Auth::routes([
    'register' => false,
    // Registration Routes...
    'reset' => false,
    // Password Reset Routes...
    'verify' => false,
    // Email Verification Routes...
]);
