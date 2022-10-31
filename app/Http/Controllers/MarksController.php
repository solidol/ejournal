<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marks;
use App\Models\User;
use App\Models\Lesson;

class MarksController extends Controller
{
    function index()
    {
        return view('marks', [
            'oList' => Marks::tester()
        ]);
    }

    function list($prep, $subj, $group){

        $additionalData = Lesson::getSubjectIfo($prep, $subj, $group)[0];        
        return view('marks', [
            'data' => [
                'title1'=> $additionalData->nomer_grup.' - '.$additionalData->subject_name ,    
                'prep'=>$prep, 
                'subj'=>$subj, 
                'group'=>$group
            ],
            'oList' => Marks::getOcTable($prep, $subj, $group),
            'mList' => User::getMySubjects($prep)
        ]);        
    }
}
