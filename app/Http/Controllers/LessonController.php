<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Subject;
use App\Models\Absent;
use App\Models\Student;
use App\Models\Mark;
use Session;
use DateTime;
use DatePeriod;
use DateInterval;

class LessonController extends Controller
{

    static $mothStrings = [
        '01' => 'Січень',
        '02' => 'Лютий',
        '03' => 'Березень',
        '04' => 'Квітень',
        '05' => 'Травень',
        '06' => 'Червень',
        '07' => 'Липень',
        '08' => 'Серпень',
        '09' => 'Вересень',
        '10' => 'Жовтень',
        '11' => 'Листопад',
        '12' => 'Грудень',
    ];
    function list($subj, $group)
    {
        $user = Auth::user();
        $additionalData = Lesson::getSubjectInfo($subj, $group);
        if ($additionalData == null)
            return view('noelement');
        return view('teacher.lessons', [
            'data' => [
                'title1' => $additionalData->group->nomer_grup . ' - ' . $additionalData->subject->subject_name,
                'prep' => $user->userable_id,
                'subj' => $subj,
                'group' => $group
            ],
            'oList' => Lesson::filterLs($subj, $group),
            'mList' => $user->getMySubjects()
        ]);
    }

    public function apiGet($lessonId){
        $lesson = Lesson::findOrFail($lessonId);
        return response()->json($lesson);
    }

    public function show($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        if (Auth::user()->userable_id != $lesson->kod_prep)
            return view('noelement');

        $subj = Subject::where('kod_subj', $lesson->kod_subj)->get()->first();

        return view(
            'teacher.lesson',
            [
                'data' => [
                    'title1' => $lesson->group->nomer_grup . " " . $subj->subject_name,
                    'title2' => 'Перегляд пари та запис відсутніх',
                ],
                'arAbsent' => Student::listByLesson($lessonId),
                'arCtrls' =>  Mark::getControlsByDate($lesson->kod_subj, $lesson->kod_grupi, $lesson->data_),
                'lesson' => $lesson,
                'arUsers' => User::all(),
            ]
        );
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        if (Auth::user()->userable_id != $lesson->kod_prep)
            return view('noelement');
        return view(
            'teacher.edit-lesson',
            [
                'data' => [
                    'title1' => 'Редагувати записану пару',
                    'prep' => $lesson->kod_prep,
                    'subj' => $lesson->kod_subj,
                    'group' => $lesson->kod_groupi
                ],
                'storeRoute' => route('update_lesson', ['lessonId' => $lessonId]),
                'lesson' => $lesson
            ]
        );
    }

    public function store(Request $request)
    {
        if ($request->get('lesscode') < 1) {
            $lesson = new Lesson();
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->userable_id;
            $lesson->kod_subj = $request->input('sbjcode');
            $lesson->nom_pari = $request->input('lessnom');
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = $request->input('hours');
            $lesson->data_ = $request->input('datetime');
            $lesson->save();
        }
        Session::flash('message', 'Пару збережено');
        return redirect()->route('get_lessons', ['subj' => $lesson->kod_subj, 'group' => $lesson->kod_grupi]);
    }

    public function update(Request $request)
    {
        if ($request->get('lesscode') > 0) {
            $lesson = Lesson::findOrFail($request->get('lesscode'));
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->userable_id;
            $lesson->kod_subj = $request->input('sbjcode');
            $lesson->nom_pari = abs(round(+$request->input('lessnom'), 0));
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = abs(round(+$request->input('hours'), 0));
            $lesson->data_ = $request->input('datetime');

            $subj = $lesson->kod_subj;
            $group = $lesson->kod_grupi;
            $lesson->save();
        }
        // redirect
        // Session::flash('message', 'Successfully updated post!');
        return redirect()->route('show_lesson', ['lessonId' => $request->get('lesscode')]);
        //return redirect()->route('show_lesson', ['subj' => $subj, 'group' => $group]);
        //  }*/
    }

    public function destroy($lessonId)
    {
        // delete
        $lesson = Lesson::find($lessonId);
        $routeData['subj'] = $lesson->kod_subj;
        $routeData['group'] = $lesson->kod_grupi;
        $lesson->delete();

        return redirect()->route('get_lessons', [
            'subj' => $routeData['subj'],
            'group' => $routeData['group']
        ]);;
    }

    public function getTable()
    {
        $date = new DateTime();
        return redirect()->route('my_table_date', ['year' => $date->format('Y'), 'month' => $date->format('m')]);
    }

    public function getTableDate($year = '2022', $month = '08')
    {
        $user = Auth::user();
        $period = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            (new DateTime($year . '-' . $month . '-01'))->modify('first day of next month')
        );

        $dates = array();
        foreach ($period as $dItem) {
            
            $tmp['raw'] = $dItem;
            $tmp['dw'] = $dItem->format('w');
            $dates[] = $tmp;
        }

        $subjects = $user->getMySubjects();
        $arSubjects = array();
        foreach ($subjects as $sItem) {
            $tmp['data'] = Lesson::filterLs($sItem->kod_subj, $sItem->kod_grupi);
            
            $tmp['meta'] = Lesson::getSubjectInfo($sItem->kod_subj, $sItem->kod_grupi);
            
            $arSubjects[] = $tmp;
        }
        return view(
            'teacher.table',
            [

                'data' => [
                    'title1' => 'Табель за ' . LessonController::$mothStrings[$month] . ' ' . $year . 'p.',
                    'last_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('last month')->format('m'),
                    'next_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('next month')->format('m'),
                ],
                'arDates' => $dates,
                'arLessons' => $arSubjects
            ]
        );
    }
}
