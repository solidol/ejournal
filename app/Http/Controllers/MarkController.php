<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        return response()->json(Mark::getControlInfo($subj, $group, $control));
    }

    function list($subj, $group)
    {

        $additionalData = Lesson::getSubjectInfo($subj, $group);
        if ($additionalData == null)
            return view('noelement');
        return view('marks', [
            'data' => [
                'title1' => $additionalData->nomer_grup . ' - ' . $additionalData->subject_name,
                'prep' => Auth::user()->usercode,
                'subj' => $subj,
                'group' => $group
            ],
            'oList' => Mark::getOcTable($subj, $group),
            'mList' => User::getMySubjects(),
            'storeRoute' => route('store_marks'),
            'createControlRoute' => route('create_control'),
        ]);
    }

    function store(Request $request)
    {
        //var_dump($request->input('marks'));
        //die();
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

            /*
            Mark::updateOrCreate(
                $searchKeys,
                $updateKeys
            );
*/
            $subj = $searchKeys['kod_subj'];
            $group = $searchKeys['kod_grup'];

            if ($mark = Mark::where($searchKeys)->first()) {

                $mark->ocenka = $value;
                $mark->data_ = $request->input('cdate');
                $mark->save();
            } else if (!is_null($value)) {

                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $request->input('cdate');
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
        $markFields['kod_prep'] = Auth::user()->usercode;
        $markFields['kod_subj'] = $request->input('sbjcode');
        $markFields['kod_grup'] = $request->input('grcode');
        $markFields['kod_stud'] = 0;
        $markFields['ocenka'] = $maxval;
        $markFields['vid_kontrol'] = $request->input('control');
        $markFields['type_kontrol'] = $request->input('typecontrol');
        $markFields['data_'] = $request->input('datetime1');
        $subj = $markFields['kod_subj'];
        $group = $markFields['kod_grup'];
        Mark::insert($markFields);
        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }

    function deleteControl($subj, $group, $control)
    {
        Mark::where('kod_prep', Auth::user()->usercode)->where('kod_subj', $subj)->where('kod_grup', $group)->where('vid_kontrol', $control)->delete();
        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }

    function updateControl(Request $request)
    {
        Mark::where('kod_prep', Auth::user()->usercode)->where('kod_subj', $request->input('sbjcode'))->where('kod_grup', $request->input('grcode'))->where('vid_kontrol', $request->input('oldcontrol'))->update(
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
