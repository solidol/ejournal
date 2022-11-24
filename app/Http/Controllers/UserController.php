<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function listSubjects()
    {

        return view('teacher', [
            'data' => array('prep' => Auth::user()->usercode),
            'mList' => Auth::user()->getMySubjects()
        ]);
    }

    function showJournal($group, $subj)
    {
        $user = Auth::user();
        return view('journal', [
            'data' => array('prep' => Auth::user()->usercode, 'group' => $group, 'subj' => $subj),
            'mList' => $user->getMySubjects()
        ]);
    }
}
