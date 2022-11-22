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
    public function listAbsents($date, $subj, $group, $lesson)
    {
    }

    public function listAbsentsByLesson($lessonId)
    {
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

    function store(Request $request)
    {
        $lessonId = $request->input('lessonid');
        $date = $request->input('date');
        $lessNom = $request->input('less_nom');
        $prep = $request->input('prep');
        $group = $request->input('group');
        $subj = $request->input('subj');

        $searchKeys['kod_lesson'] = $lessonId;
        Absent::where($searchKeys)->delete();
        foreach ($request->input('abs') as $key => $value) {
            if (!empty($value)) {
                $updateKeys['kod_lesson'] = $lessonId;
                $updateKeys['kod_prepod'] = $prep;
                $updateKeys['kod_subj'] = $subj;
                $updateKeys['kod_grup'] = $group;
                $updateKeys['kod_stud'] = $key;
                $updateKeys['data_'] = $date;
                $updateKeys['nom_pari'] = $lessNom;
                $updateKeys['pricina'] = 'test';
                Absent::insert($updateKeys);
            }
        }

        return redirect()->route('show_lesson', ['lessonId' => $lessonId]);
    }
}
