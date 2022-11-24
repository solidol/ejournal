<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    function show()
    {
        $user = Auth::user();
        return view('auth.profile',['user'=>$user]);
    }

    function anotherLoginForm()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('name')->get();
            return view('auth.another', ['users' => $users]);
        } else
            return view('auth.login');
    }

    function anotherLogin(Request $request)
    {

        if (Auth::user()->isAdmin() && $request->input('userid') > 0) {

            Auth::loginUsingId($request->input('userid'));

            return redirect()->route('get_subjects');
        } else
            return view('auth.login');
    }

    function listSubjects()
    {
        $user = Auth::user();
        return view('teacher', [
            'data' => array('prep' => $user->usercode),
            'mList' => $user->getMySubjects()
        ]);
    }

    function showJournal($group, $subj)
    {
        $user = Auth::user();
        return view('journal', [
            'data' => array('prep' => $user->usercode, 'group' => $group, 'subj' => $subj),
            'mList' => $user->getMySubjects()
        ]);
    }
}
