<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function index()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('name')->get();
            $teachers = Teacher::orderBy('FIO_prep')->leftJoin('users', 'users.usercode', '=', 'prepod.kod_prep')->get();
            return view('admin.users', ['users' => $users, 'teachers' => $teachers]);
        } else
            return view('auth.login');
    }

    function show()
    {
        $user = Auth::user();
        return view('auth.profile', ['user' => $user]);
    }

    function anotherLoginForm()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('name')->get();
            return view('admin.another', ['users' => $users]);
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
        $groups = DB::table('grups')->orderBy('nomer_grup')->get();
        $subjects = DB::table('subjects')->orderBy('subject_name')->get();
        return view('teacher', [
            'data' => array('prep' => $user->usercode),
            'mySubjList' => $user->getMySubjects(),
            'grList' => $groups,
            'sbjList' => $subjects,
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
