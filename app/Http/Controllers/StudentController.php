<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Yajra\DataTables\DataTables;
use Faker;

class StudentController extends Controller
{

    function index()
    {
        if (\request()->ajax()) {
            $students = Student::orderBy('FIO_stud', 'asc');
            return DataTables::of($students)
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

    public function rnd()
    {
        $faker = Faker\Factory::create();
        $ints = array();
        $floats = array();
        for ($i =0; $i<100; $i++){
            $ints[$i] = $faker->numberBetween(-100,100);
            $floats[$i] = $faker->randomFloat(2,-100,100);
        }
        $fk = [
            'paragraph' =>$faker->text(5000),
            'word'=>$faker->word(),
            'sentence'=>$faker->sentence(),
            'ints'=>$ints,
            'floats'=>$floats,
        ];
        $fk = (object) $fk;
        return view('student.fakers.show', ['fk' => $fk]);
    }
}
