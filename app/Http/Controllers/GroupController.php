<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    function studentTeachers()
    {

        $teachers = Auth::user()->userable->group->teachers()->orderBy('FIO_prep')->get();
        return view('student.teachers.index', [
            'group' => Auth::user()->userable->group,
            'teachers' => $teachers
        ]);
    }
}
