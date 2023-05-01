<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Control;
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

    function store($id, Request $request)
    {
        $control = Control::find($id);
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

            $searchKeys['control_id'] = $id;
            $searchKeys['kod_stud'] = $key;

            $updateKeys['ocenka'] = $value;

            if ($mark = Mark::where($searchKeys)->first()) {
                $mark->ocenka = $value;
                $mark->save();
            } else if (!is_null($value)) {
                $searchKeys['kod_prep'] = $control->journal->teacher_id;
                $searchKeys['kod_subj'] = $control->journal->subject_id;
                $searchKeys['kod_grup'] = $control->journal->group_id;
                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $control->date_;
                $searchKeys['vid_kontrol'] = $control->title;
                Mark::insert($searchKeys);
            }
        }

        return redirect()->route('show_control', ['journal_id' => $control->journal->id, 'control_id' => $control->id]);
    }
}
