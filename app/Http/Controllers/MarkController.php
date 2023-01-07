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

    function apiIndex($subj, $group, $control)
    {
        $info = Mark::getControlInfo($subj, $group, $control);
        if (!$info->data_) $info->data_ = "2000-00-00";
        return response()->json($info);
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

    function createControl(Request $request)
    {
        $maxval = $request->input('maxval');
        switch ($maxval) {

            case 'З':
            case 'з':
            case 'Зар':
            case 'зар':
                $maxval = -2;
                break;
            default:
                break;
        }
        if (!is_numeric($maxval)) $maxval = 0;
        $markFields['kod_prep'] = Auth::user()->userable_id;
        $markFields['kod_subj'] = $request->input('sbjcode');
        $markFields['kod_grup'] = $request->input('grcode');
        $markFields['vid_kontrol'] = $request->input('control');
        $subj = $markFields['kod_subj'];
        $group = $markFields['kod_grup'];

        $controlCount = Mark::where($markFields)->count();
        if ($controlCount > 0) {
            Session::flash('warning', 'Контроль вже існує!');
            return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
        } else {
            $markFields['ocenka'] = $maxval;
            $markFields['type_kontrol'] = $request->input('typecontrol');
            $markFields['data_'] = $request->input('date_control');
            $markFields['kod_stud'] = 0;
            Mark::create($markFields);
            Session::flash('message', 'Контроль створено');
            return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
        }
    }

    function deleteControl($subj, $group, $control)
    {
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $subj)->where('kod_grup', $group)->where('vid_kontrol', $control)->delete();
        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }

    function updateControl(Request $request)
    {
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $request->input('sbjcode'))->where('kod_grup', $request->input('grcode'))->where('vid_kontrol', $request->input('oldcontrol'))->where('kod_stud', '>', 0)->update(
            [
                'vid_kontrol' => $request->input('control'),
                'data_' => $request->input('datetime2'),
                'type_kontrol' => $request->input('typecontrol')
            ]
        );
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $request->input('sbjcode'))->where('kod_grup', $request->input('grcode'))->where('vid_kontrol', $request->input('oldcontrol'))->where('kod_stud', 0)->update(
            [
                'vid_kontrol' => $request->input('control'),
                'data_' => $request->input('datetime2'),
                'ocenka' => $request->input('maxval'),
                'type_kontrol' => $request->input('typecontrol')
            ]
        );
        return redirect()->route('get_marks', ['subj' => $request->input('sbjcode'), 'group' => $request->input('grcode')]);
    }
}
