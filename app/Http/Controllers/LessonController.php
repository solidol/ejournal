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
use App\Models\Control;
use Illuminate\Support\Facades\Session;
use DateTime;
use DatePeriod;
use DateInterval;

class LessonController extends Controller
{
    function index($id)
    {
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('lessons.index', [
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    public function show(Lesson $lesson)
    {
        if (\request()->ajax()) {
            return response()->json($lesson);
        }
        if (Auth::user()->userable_id != $lesson->kod_prep)
            return view('noelement');
        return view(
            'lessons.show',
            [
                'currentJournal' => $lesson->journal,
                'arCtrls' =>  Control::where('date_', $lesson->data_)->get(),
                'lesson' => $lesson,
                'arUsers' => User::all()
            ]
        );
    }

    public function edit(Lesson $lesson)
    {
        if (Auth::user()->userable_id != $lesson->kod_prep)
            return view('noelement');
        return view(
            'lessons.edit',
            [
                'data' => [
                    'title1' => 'Редагувати записану пару',
                    'prep' => $lesson->kod_prep,
                    'subj' => $lesson->kod_subj,
                    'group' => $lesson->kod_groupi
                ],
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
        return redirect()->route('lessons.index', ['id' => $journal->id]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        if ($lesson) {
            $hr = abs(round(+$request->input('hours'), 0));
            $np = abs(round(+$request->input('lessnom'), 0));
            $lesson->kod_grupi = $request->input('grcode') ?? $lesson->kod_grupi;
            $lesson->kod_prep = Auth::user()->userable_id;
            $lesson->kod_subj = $request->input('sbjcode') ?? $lesson->kod_subj;
            $lesson->nom_pari =  $np > 0 ? $np : $lesson->nom_pari;
            $lesson->tema = $request->input('thesis') ?? $lesson->tema;
            $lesson->zadanaie = $request->input('homework') ?? $lesson->zadanaie;
            $lesson->kol_chasov = $hr > 0 ? $hr : $lesson->kol_chasov;
            $lesson->data_ = $request->input('datetime') ?? $lesson->data_;
            $lesson->save();
        }
        if (\request()->ajax()) {
            return response()->json(['status' => 'OK']);
        }
        Session::flash('message', 'Successfully updated post!');
        return redirect()->route('lessons.show', ['lesson' => $lesson]);
    }

    public function destroy($id)
    {
        // delete
        $lesson = Lesson::find($id);
        $journal = $lesson->journal;
        $lesson->delete();
        if ($journal->lessons->count() > 0) {
            return redirect()->route('lessons.index', [
                'id' => $journal->id
            ]);
        } else {
            $journal->delete();
            return redirect()->route('journals.index');
        }
    }
}
