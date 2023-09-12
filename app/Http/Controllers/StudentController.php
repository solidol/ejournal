<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{

    function index()
    {
        if (\request()->ajax()) {
            $students = Student::orderBy('FIO_stud','asc');
            return  DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('group', function ($student) {
                    return $student->group->title;
                })
                ->addColumn('action', function ($student) {
                    $actionBtn = '<a class="btn btn-success py-0" href="' .
                        route('journals.index', ['group' => $student->group->id]) .
                        '"><i class="bi bi-pencil-square"></i> Журнали</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('students.index');
    }

    /*
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
    */
}
