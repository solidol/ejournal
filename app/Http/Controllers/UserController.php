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
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index($slug = 'teachers')
    {

        if (Auth::user()->isAdmin()) {


            if (\request()->ajax()) {
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
                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('fullname', function ($user) {
                        return $user->userable->fullname;
                    })
                    ->addColumn('action', function ($user) {
                        $actionBtn = '<a href="' . route('users.loginas', ['user' => $user]) . '" class="btn btn-success btn-login" data-uid="' . $user->id . '">Увійти</a>';
                        return $actionBtn;
                    })

                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('users.index', ['slug' => $slug]);
        } else
            return view('auth.login');
    }

    function apiGet($teacherId)
    {
        $info = Teacher::find($teacherId);
        return response()->json($info);
    }

    function show(User $user)
    {
        if (Auth::user()->isAdmin()) {
            return view('auth.profile', ['user' => $user]);
        } else
            return view('auth.login');
    }

    function myShow()
    {
        $user = Auth::user();
        return view('auth.profile', ['user' => $user]);
    }

    function loginAs(User $user)
    {

        if (Auth::user()->isAdmin()) {
            Log::loginAs($user->id);
            Auth::loginUsingId($user->id);
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
