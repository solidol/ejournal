<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function find(Request $request)
    {

        if ($request->fullname == null) {
            $students = array();
        } else {
            $students = Student::where('FIO_stud', 'LIKE', '%' . $request->fullname . '%')->get();
        }
        return view('teacher.students_list', ['students' => $students]);
    }
}
