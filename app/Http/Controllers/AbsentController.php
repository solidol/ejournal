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
        $lessonId = $request->input('marks');
        foreach ($request->input('marks') as $key => $value) {
            switch ($value) {
                case 'Н/А':
                case 'НА':
                case 'н/а':
                case 'на':
                    $value = -1;
                    break;
                case 'З':
                case 'з':
                case 'Зар':
                case 'зар':
                    $value = -2;
                    break;
                default:
                    break;
            }
            if (!is_numeric($value)) $value = null;
            $tmpKeys = explode("_", $key);
            $searchKeys['kod_prep'] = $tmpKeys[0];
            $searchKeys['kod_subj'] = $tmpKeys[1];
            $searchKeys['kod_grup'] = $tmpKeys[2];
            $searchKeys['kod_stud'] = $tmpKeys[3];
            $searchKeys['vid_kontrol'] = $tmpKeys[4];

            $updateKeys['ocenka'] = $value;

            $subj = $searchKeys['kod_subj'];
            $group = $searchKeys['kod_grup'];

            if ($mark = Absent::where($searchKeys)->first()) {

                $mark->ocenka = $value;
                $mark->data_ = $request->input('cdate');
                $mark->save();
            } else if (!is_null($value)) {

                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $request->input('cdate');
                Absent::insert($searchKeys);
            }
        }

        return redirect()->route('show_lesson', ['lessonId' => $lessonId]);
    }
}
