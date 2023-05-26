<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProject;

class DiplomaProjectController extends Controller
{
    //
    public function store(Request $request)
    {
        $dp = new DiplomaProject();
        $dp->title = $request->title;
        $dp->student_id = $request->student_id;
        $dp->teacher_id = $request->teacher_id;
        $dp->diploma_projecting_id = $request->diploma_projecting_id;
        $dp->reporting_date = $request->reporting_date;
        $dp->prot_number = $request->prot_number;
        $dp->prot_subnumber = $request->prot_subnumber;
        $dp->project_type = $request->project_type;
        $dp->save();

        return redirect()->route('diploma_projectings_show', ['id' => $request->diploma_projecting_id]);
    }

    public function delete($id)
    {
        $dp = DiplomaProject::find($id);
        $dpp = $dp->diploma_projecting_id;
        $dp->delete();
        return redirect()->route('diploma_projectings_show', ['id' => $dpp]);
    }


}
