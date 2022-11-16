<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absent;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsentController extends Controller
{
    //
    public function listAbsents($date, $subj, $group, $lesson){

    }

    public function listAbsentsByLesson($lessonId){
        dd(Absent::listByLesson($lessonId));
        return response()->json(Absent::listByLesson($lessonId));
    }
}
