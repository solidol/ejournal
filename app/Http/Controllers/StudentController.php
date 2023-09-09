<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $res = str_ireplace(['\'', '"', ',', '.', ':', '*', ';', '<', '>', '%', '\n'], '', $request->fullname);
        if ($res == null) {
            $students = array();
        } else {
            $students = Student::where('FIO_stud', 'LIKE', "%{$res}%")->paginate(25);
            $students->appends(array('fullname' => $request->fullname,));
        }
        
        return view('students.index', ['students' => $students]);
    }
}
