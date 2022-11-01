<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marks;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class MarksController extends Controller
{
    function index()
    {
        return view('marks', [
            'oList' => Marks::tester()
        ]);
    }

    function list($subj, $group){

        $additionalData = Lesson::getSubjectInfo($subj, $group);
        if ($additionalData == null)  
        return view('noelement');     
        return view('marks', [
            'data' => [
                'title1'=> $additionalData->nomer_grup.' - '.$additionalData->subject_name ,    
                'prep'=>Auth::user()->usercode, 
                'subj'=>$subj, 
                'group'=>$group
            ],
            'oList' => Marks::getOcTable($subj, $group),
            'mList' => User::getMySubjects()
        ]);        
    }
}
