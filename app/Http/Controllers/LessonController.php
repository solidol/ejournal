<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    function nowIndex()
    {
        if (Auth::user()->isStudent()) {
            $student = Auth::user()->userable;
            $lessons = Lesson::where('kod_grupi', $student->kod_grup)->where('created_at', '>=', now()->subMinutes(30))->
                //where('created_at','>=',date("Y-m-d H:i:s"))->
                get();
            return view('student.lessons.current', ['lessons' => $lessons]);
        } else {
            return view('noelement');
        }
    }

    function now(Request $request, Lesson $lesson)
    {
        if (!$request->hasValidSignature()) {
            if (\request()->ajax())
                response()->json(['message' => 'Посилання не дійсне!', 'status' => 'expired'], 406);
            else
                abort(406);
        }
        $user = Auth::user();
        $lesson->journal->teacher;
        $lesson->journal->subject;
        if ($user->isStudent()) {
            if (\request()->ajax()) {
                return response()->json([
                    'lesson' => $lesson,
                    'checked' => $lesson->isPresent($user->userable)
                ]);
            } else
                return view('student.lessons.show', ['lesson' => $lesson]);
        } else {
            return view('noelement');
        }
    }

    function checkinLink(Lesson $lesson)
    {
        $response['url'] = $lesson->student_url;
        return response()->json($response);
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
                'arCtrls' => Control::where('date_', $lesson->data_)->get(),
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
            if ($request->copy_to_div) {
                $div = $journal->children()->first();
                $dLesson = new Lesson();
                $dLesson->kod_grupi = $div->group_id;
                $dLesson->kod_prep = $div->teacher_id;
                $dLesson->kod_subj = $div->subject_id;
                $dLesson->journal_id = $div->id;
                $dLesson->nom_pari = $request->input('lessnom');
                $dLesson->tema = $request->input('thesis');
                $dLesson->zadanaie = $request->input('homework');
                $dLesson->kol_chasov = $request->input('hours');
                $dLesson->data_ = $request->input('datetime');
                $dLesson->save();
            }
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
            $lesson->nom_pari = $np > 0 ? $np : $lesson->nom_pari;
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
