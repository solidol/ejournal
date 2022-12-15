<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('name')->get();
            $teachers = Teacher::orderBy('FIO_prep')->leftJoin('users', 'users.userable_id', '=', 'prepod.kod_prep')->get();
            return view('admin.users', ['users' => $users, 'teachers' => $teachers]);
        } else
            return view('auth.login');
    }

    function apiGet($teacherId)
    {
        $info = Teacher::find($teacherId);
        return response()->json($info);
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
            
            return view('admin.login-as', ['users' => $users]);
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
        return view('teacher.journals', [
            'data' => array('prep' => $user->userable_id),
            'mySubjList' => $user->getMySubjects(),
            'grList' => $groups,
            'sbjList' => $subjects,
        ]);
    }

    function showJournal($group, $subj)
    {
        $user = Auth::user();
        return view('teacher.journal', [
            'data' => array('prep' => $user->userable_id, 'group' => $group, 'subj' => $subj),
            'mList' => $user->getMySubjects()
        ]);
    }

    function WUStore(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'userable_id' => $request->userable_id,
                'userable_type' => 'App\Models\Teacher',
                'password' => Hash::make($request->password),
                'roles' => 'teacher',
            ]);

            return redirect()->route('admin_userlist');
        } else
            return view('auth.login');
    }    
}
