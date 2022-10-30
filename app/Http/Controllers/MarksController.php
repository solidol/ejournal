<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marks;
use App\User;

class MarksController extends Controller
{
    function index()
    {
        return view('marks', [
            'oList' => Marks::tester()
        ]);
    }

    function list($prep, $group, $subj){
        return view('marks', [
            'data' => array('prep'=>$prep, 'group'=>$group, 'subj'=>$subj),
            'oList' => Marks::getOcTable($prep, $group, $subj),
            'mList' => User::getMySubjects($prep)
        ]);        
    }
}
