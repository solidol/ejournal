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
        $lesson = Lesson::find($id);
        $searchKeys['kod_lesson'] = $lesson->id;
        Absent::where($searchKeys)->delete();
        foreach ($request->abs as $key => $value) {
            if (!empty($value)) {
                $updateKeys['kod_lesson'] = $lesson->id;
                $updateKeys['kod_prepod'] = $lesson->journal->teacher_id;
                $updateKeys['kod_subj'] = $lesson->journal->subject_id;
                $updateKeys['kod_grup'] = $lesson->journal->group_id;
                $updateKeys['kod_stud'] = $key;
                $updateKeys['data_'] = $lesson->data_;
                $updateKeys['nom_pari'] = $lesson->nom_pari;
                $updateKeys['pricina'] = 'test';
                Absent::insert($updateKeys);
            }
        }
        return redirect()->route('show_lesson', ['id' => $lesson->id]);
    }
}
