<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marks;
use App\User;
use App\Lesson;

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
                'title1'=> mb_convert_encoding($additionalData->nomer_grup.' - '.$additionalData->subject_name, "utf-8", "windows-1251") ,    
                'prep'=>$prep, 
                'subj'=>$subj, 
                'group'=>$group
            ],
            'oList' => Marks::getOcTable($prep, $subj, $group),
            'mList' => User::getMySubjects($prep)
        ]);        
    }
}
