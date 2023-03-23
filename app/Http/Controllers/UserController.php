<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('name')->get();
            return view('admin.users_list', ['users' => $users]);
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

    function anotherLogin(Request $request)
    {

        if (Auth::user()->isAdmin() && $request->input('userid') > 0) {
            Log::loginAs($request->input('userid'));
            Auth::loginUsingId($request->input('userid'));

            return redirect()->route('get_journals');
        } else
            return view('auth.login');
    }


    function curatorGroups()
    {
        $journal = false;

        return view('curator.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->groups->first()->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

}
