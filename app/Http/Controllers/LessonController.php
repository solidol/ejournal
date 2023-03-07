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
use App\Models\Journal;
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
    function list($id)
    {
        $user = Auth::user();
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('teacher.lessons', [
            'data' => [
                'title1' => $journal->group->nomer_grup . ' - ' . $journal->subject->subject_name,
                'prep' => $user->userable_id,
            ],
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals
        ]);
    }

    public function apiGet($id)
    {
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson);
    }

    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        if (Auth::user()->userable_id != $lesson->kod_prep)
            return view('noelement');

        $subj = Subject::where('kod_subj', $lesson->kod_subj)->get()->first();

        return view(
            'teacher.lesson_show',
            [
                'data' => [
                    'title1' => $lesson->group->nomer_grup . " " . $subj->subject_name,
                    'title2' => 'Перегляд пари та запис відсутніх',
                ],
                'arAbsent' => Student::listByLesson($id),
                'arCtrls' =>  Mark::getControlsByDate($lesson->kod_subj, $lesson->kod_grupi, $lesson->data_),
                'lesson' => $lesson,
                'arUsers' => User::all(),
            ]
        );
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);

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
                'storeRoute' => route('update_lesson', ['id' => $id]),
                'lesson' => $lesson
            ]
        );
    }

    public function store(Request $request)
    {
        if ($request->lesscode < 1 && $request->journal_id > 0) {
            $journal = Journal::find($request->journal_id);
            $lesson = new Lesson();
            $lesson->kod_grupi = $journal->group_id;
            $lesson->kod_prep = $journal->teacher_id;
            $lesson->kod_subj = $journal->subject_id;
            $lesson->journal_id = $journal->id;
            $lesson->nom_pari = $request->input('lessnom');
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = $request->input('hours');
            $lesson->data_ = $request->input('datetime');
            $lesson->save();
        }
        Session::flash('message', 'Пару збережено');
        return redirect()->route('get_lessons', ['id' => $journal->id]);
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
        return redirect()->route('show_lesson', ['id' => $request->get('lesscode')]);
        //return redirect()->route('show_lesson', ['subj' => $subj, 'group' => $group]);
        //  }*/
    }

    public function destroy($id)
    {
        // delete
        $lesson = Lesson::find($id);
        $journal = $lesson->journal;
        $lesson->delete();
        if ($journal->lessons->count() > 0) {
            return redirect()->route('get_lessons', [
                'id' => $journal->id
            ]);
        } else {
            $journal->delete();
            return redirect()->route('get_journals');
        }
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
