<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProjecting;
use App\Models\DiplomaProject;
use App\Models\Student;
use App\Models\Teacher;

class DiplomaProjectingController extends Controller
{
    public function index()
    {
        $myProjectings =  DiplomaProjecting::all();
        return view('dp_scribe.dp_list', ['dp' => $myProjectings]);
    }

    public function show($id)
    {
        $currentProjecting = DiplomaProjecting::find($id);
        $students = $currentProjecting->group->students;
        $projects = DiplomaProject::where('diploma_projecting_id', $currentProjecting->id)->get();
        //dd($projects);
        $teachers = Teacher::all();
        return view('dp_scribe.dp_show', [
            'currentProjecting' => $currentProjecting,
            'students' => $students,
            'teachers' => $teachers,
            'projects' => $projects,
        ]);
    }

    public function update(request $request, $id)
    {
        $currentProjecting = DiplomaProjecting::find($id);
        $currentProjecting->chief = $request->chief;
        $currentProjecting->committee = $request->committee;
        $currentProjecting->com_number = $request->com_number;
        $currentProjecting->com_date = $request->com_date;
        $currentProjecting->save();
        return redirect()->route('diploma_projectings_show',['id'=>$id]);
    }
}
