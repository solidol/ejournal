<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function listSubjects(){

        return view('teacher', [
            'data' => array('prep'=>Auth::user()->usercode),
            'mList' => User::getMySubjects()
        ]);        
    }

    function showJournal($group, $subj){
        return view('journal', [
            'data' => array('prep'=>Auth::user()->usercode, 'group'=>$group, 'subj'=>$subj),
            'mList' => User::getMySubjects(Auth::user()->usercode)
        ]);        
    }


}
