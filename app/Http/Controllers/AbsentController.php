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
        $arAbs = Absent::listByLesson($lessonId);
        return view('absents', [
            'data' => [
                'title1' => '',
                'prep' => Auth::user()->usercode,
                //'subj' => $subj,
                //'group' => $group
            ],
            'storeRoute' => route('create_lesson', ['subj' => -1, 'group' => -1]),
            //'oList' => Lesson::filterLs($subj, $group),
            //'mList' => User::getMySubjects()
        ]);
        
    }
}
