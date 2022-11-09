<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use DateTime;
use DatePeriod;
use DateInterval;

class LessonController extends Controller
{
    function list($subj, $group)
    {
        $additionalData = Lesson::getSubjectInfo($subj, $group);
        if ($additionalData == null)
            return view('noelement');
        return view('lessons', [
            'data' => [
                'title1' => $additionalData->nomer_grup . ' - ' . $additionalData->subject_name,
                'prep' => Auth::user()->usercode,
                'subj' => $subj,
                'group' => $group
            ],
            'storeRoute' => route('create_lesson', ['subj' => $subj, 'group' => $group]),
            'oList' => Lesson::filterLs($subj, $group),
            'mList' => User::getMySubjects()
        ]);
    }

    public function edit($lessId)
    {
        $lesson = Lesson::findOrFail($lessId);

        if (Auth::user()->usercode != $lesson->kod_prep)
            return view('noelement');
        return view(
            'edit-lesson',
            [
                'data' => [
                    'title1' => 'Редагувати записану пару',
                    'prep' => $lesson->kod_prep,
                    'subj' => $lesson->kod_subj,
                    'group' => $lesson->kod_groupi
                ],
                'storeRoute' => route('update_lesson', ['lessId' => $lessId]),
                'lesson' => $lesson
            ]
        );
    }

    public function create(Request $request)
    {


        if ($request->get('lesscode') < 1) {
            $lesson = new Lesson();
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->usercode;
            $lesson->kod_subj = $request->input('sbjcode');
            $lesson->nom_pari = $request->input('lessnom');
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = $request->input('hours');
            $lesson->data_ = $request->input('datetime');
            $lesson->save();
        }

        // redirect

        return redirect()->route('get_lessons', ['subj' => $lesson->kod_subj, 'group' => $lesson->kod_grupi]);
    }

    public function update(Request $request)
    {
        if ($request->get('lesscode') > 0) {
            $lesson = Lesson::findOrFail($request->get('lesscode'));
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->usercode;
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
        return redirect()->route('get_lessons', ['subj' => $subj, 'group' => $group]);
        //  }*/
    }

    public function destroy($lessId)
    {
        // delete
        $lesson = Lesson::find($lessId);
        $routeData['subj'] = $lesson->kod_subj;
        $routeData['group'] = $lesson->kod_grupi;
        $lesson->delete();

        return redirect()->route('get_lessons', [
            'prep' => Auth::user()->usercode,
            'subj' => $routeData['subj'],
            'group' => $routeData['group']
        ]);;
    }

    public function getTable()
    {
        $period = new DatePeriod(
            new DateTime('2022-08-15'),
            new DateInterval('P1D'),
            new DateTime('2022-12-31')
        );

        $dates = array();
        foreach ($period as $dItem) {
            $dates[] = $dItem->format('d.m.y');
        }

        $subjects = User::getMySubjects();
        $arSubjects = array();
        foreach ($subjects as $sItem) {
            $tmp['data'] = Lesson::filterLs($sItem->kod_subj, $sItem->kod_grup);
            $tmp['meta'] = Lesson::getSubjectInfo($sItem->kod_subj, $sItem->kod_grup);
            //dd($tmp['meta']);
            $arSubjects[] = $tmp;
        }



        //dd($additionalData);
        return view(
            'table',
            [
                /*
            'data' => [
                'title1' => 'Редагувати записану пару',
                'prep' => $lesson->kod_prep,
                'subj' => $lesson->kod_subj,
                'group' => $lesson->kod_groupi
            ],*/
                'arDates' => $dates,
                'arLessons' => $arSubjects
            ]
        );
    }
}
