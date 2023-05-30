<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProjecting;
use App\Models\DiplomaProject;
use App\Models\Group;
use App\Models\Teacher;

class DiplomaProjectingController extends Controller
{
    public function index()
    {
        $myProjectings =  DiplomaProjecting::all();
        $groups = Group::all();
        $teachers = Teacher::all();
        return view('dpscriber.dp_list', [
            'dp' => $myProjectings,
            'groups' => $groups,
            'teachers' => $teachers
        ]);
    }

    public function show($id)
    {
        $currentProjecting = DiplomaProjecting::find($id);
        $students = $currentProjecting->group->students;
        $myProjectings =  DiplomaProjecting::all();
        $projects = DiplomaProject::where('diploma_projecting_id', $currentProjecting->id)->orderBy('variant')->get();
        //dd($projects);
        $teachers = Teacher::all();
        return view('dpscriber.dp_show', [
            'dp' => $myProjectings,
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
        $currentProjecting->scriber_id = $request->scriber_id;
        $currentProjecting->com_date = $request->com_date;
        $currentProjecting->save();
        return redirect()->route('diploma_projectings_show', ['id' => $id]);
    }

    public function store(Request $request)
    {
        $dp = new DiplomaProjecting();
        $dp->group_id = $request->group_id;
        $dp->scriber_id = $request->scriber_id;
        $dp->template = $request->template;
        $dp->save();

        return redirect()->route('diploma_projectings_show', ['id' => $dp->id]);
    }
}
