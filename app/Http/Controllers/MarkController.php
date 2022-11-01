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
            'oList' => Mark::getOcTable($subj, $group),
            'mList' => User::getMySubjects()
        ]);        
    }

    function store(Request $request){
        foreach($request->input('marks') as $key=>$value){

        }
        

    }
}
