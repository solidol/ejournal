<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProject;
use App\Models\DiplomaProjecting;
use App\Models\Teacher;

class DiplomaProjectController extends Controller
{
    //
    public function store(Request $request)
    {
        $dp = new DiplomaProject();
        $dp->variant = $request->variant;
        $dp->title = $request->title;
        $dp->student_id = $request->student_id;
        $dp->teacher_id = $request->teacher_id;
        $dp->diploma_projecting_id = $request->diploma_projecting_id;
        $dp->reporting_date = $request->reporting_date;
        $dp->prot_number = $request->prot_number;
        $dp->prot_subnumber = $request->prot_subnumber;
        $dp->project_type = $request->project_type;
        $dp->questions = $request->questions??'';
        $dp->save();

        return redirect()->route('diploma_projectings_show', ['id' => $request->diploma_projecting_id]);
    }

    public function update(Request $request, $id)
    {
        $dp = DiplomaProject::find($id);
        $dp->variant = $request->variant;
        $dp->title = $request->title;
        //$dp->student_id = $request->student_id;
        $dp->teacher_id = $request->teacher_id;
        //$dp->diploma_projecting_id = $request->diploma_projecting_id;
        $dp->reporting_date = $request->reporting_date;
        $dp->prot_number = $request->prot_number;
        $dp->prot_subnumber = $request->prot_subnumber;
        $dp->project_type = $request->project_type;
        $dp->mark = $request->mark;
        $dp->pages = $request->pages;
        $dp->slides = $request->slides;
        $dp->minutes = $request->minutes;
        $dp->questions = $request->questions??'';
        $dp->save();

        return redirect()->route('diploma_project_show', ['id' => $dp->id]);
    }



    function show($id){
        $currentProject = DiplomaProject::find($id);
        $myProjectings =  DiplomaProjecting::all();
        $teachers = Teacher::all();
        return view('dpscriber.dp_project_show', [
            'dp' => $myProjectings,
            'currentProject' => $currentProject,
            'teachers' => $teachers,
        ]);
    }

    public function delete($id)
    {
        $dp = DiplomaProject::find($id);
        $dpp = $dp->diploma_projecting_id;
        $dp->delete();
        return redirect()->route('diploma_projectings_show', ['id' => $dpp]);
    }


}
