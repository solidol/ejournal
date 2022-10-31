<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    function listSubjects($prep){

        return view('teacher', [
            'data' => array('prep'=>$prep),
            'mList' => User::getMySubjects($prep)
        ]);        
    }

    function showJournal($prep, $group, $subj){
        return view('journal', [
            'data' => array('prep'=>$prep, 'group'=>$group, 'subj'=>$subj),
            'mList' => User::getMySubjects($prep)
        ]);        
    }
}
