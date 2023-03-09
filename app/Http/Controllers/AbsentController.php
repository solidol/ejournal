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

    function store($id, Request $request)
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
