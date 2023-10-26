<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Control;
use App\Models\Group;
use App\Models\Practice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentPracticeController extends Controller
{
    function index($id)
    {

    }

    function show(Practice $practice)
    {
        //$journals = Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title');
        return view('student.practices.show', [
            'student' => Auth::user()->userable,
            'control' => $practice
        ]);
    }
}
