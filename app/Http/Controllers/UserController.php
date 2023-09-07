<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index($slug = 'teachers')
    {
        if (Auth::user()->isAdmin()) {
            switch ($slug) {
                case 'teachers':
                    $users = User::teachers();
                    break;
                case 'students':
                    $users = User::students();
                    break;
                default:
                    $users = User::teachers();
                    break;
            }
            $users = $users->orderBy('name')->get();
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
            Session::put('localrole', null);
            return redirect()->route('journals.index');
        } else
            return view('auth.login');
    }


    function curatorGroups()
    {
        $journal = false;
        $groups = Auth::user()->userable->groups;
        return view('curator.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'groups' => $groups,
            //'journals' => Auth::user()->userable->groups->first()->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    function createToken(Request $request)
    {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    }
}
