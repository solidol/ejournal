<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

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
                $mark->save();
            } else {
                $searchKeys['ocenka'] = $value;

                Mark::insert($searchKeys);
            }
        }

        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }

    function createControl(Request $request)
    {
        $markFields['kod_prep'] = Auth::user()->usercode;
        $markFields['kod_subj'] = $request->input('sbjcode');
        $markFields['kod_grup'] = $request->input('grcode');
        $markFields['kod_stud'] = null;
        $markFields['vid_kontrol'] = $request->input('control');
        $markFields['data_'] = $request->input('datetime1');
        $subj = $markFields['kod_subj'];
        $group = $markFields['kod_grup'];
        Mark::insert($markFields);
        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }
}
