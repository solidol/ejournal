<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class MarkController extends Controller
{
    function index()
    {
        return view('marks', [
            'oList' => Mark::tester()
        ]);
    }



    function list($subj, $group)
    {
        $user = Auth::user();
        $lesson = Lesson::getSubjectInfo($subj, $group);

        if ($lesson == null)
            return view('noelement');
        return view('teacher.marks', [
            'data' => [
                'title1' => $lesson->group->nomer_grup . ' - ' . $lesson->subject->subject_name,
            ],
            'oList' => Mark::getOcTable($subj, $group),
            'mList' => $user->getMySubjects(),
            'lesson' => $lesson,
        ]);
    }

    function store(Request $request)
    {
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

            if ($mark = Mark::where($searchKeys)->first()) {

                $mark->ocenka = $value;
                $mark->data_ = $request->input('date_control');
                $mark->save();
            } else if (!is_null($value)) {

                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $request->input('date_control');
                Mark::insert($searchKeys);
            }
        }

        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }



}
