<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Journal;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class JournalController extends Controller
{
    function list()
    {
        $user = Auth::user();
        $groups = DB::table('grups')->orderBy('nomer_grup')->get();
        $subjects = DB::table('subjects')->orderBy('subject_name')->get();
        $journals = $user->userable->journals()->with('group')->get()->sortBy('group.title');
        return view('teacher.journals_list', [
            'data' => array('prep' => $user->userable_id),
            'journals' => $journals,
            'grList' => $groups,
            'sbjList' => $subjects,
        ]);
    }

    function studentMarks($id = false)
    {
        if ($id) {
            $journal = Auth::user()->userable->group->journals->find($id);
        } else {
            $journal = false;
        }
        if ($journal == null) {
            $journal = false;
        }
        return view('student.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->group->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    function show($id)
    {
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('teacher.journal_show', [
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }
    function marks($id)
    {
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('teacher.marks_tabs_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    function marksSheet($id)
    {
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('teacher.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    function curatorMarks($id)
    {
        $journal = Journal::find($id);
        if ($journal == null)
            return view('noelement');
        $groups = Auth::user()->userable->groups;
        return view('curator.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'groups' => $groups,
            //'journals' => Auth::user()->userable->groups->first()->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }



    public function store(Request $request)
    {

        $journal = new Journal();
        $journal->group_id = $request->grcode;
        $journal->subject_id = $request->sbjcode;
        $journal->teacher_id = Auth::user()->userable_id;
        $journal->description = $request->description;
        $journal->save();
        $lesson = new Lesson();
        $lesson->kod_grupi = $journal->group_id;
        $lesson->kod_prep = $journal->teacher_id;
        $lesson->kod_subj = $journal->subject_id;
        $lesson->journal_id = $journal->id;
        $lesson->nom_pari = $request->lessnom;
        $lesson->tema = $request->thesis;
        $lesson->zadanaie = $request->homework;
        $lesson->kol_chasov = $request->hours;
        $lesson->data_ = $request->datetime;
        $lesson->save();

        Session::flash('message', 'Пару збережено');
        return redirect()->route('get_lessons', ['id' => $journal->id]);
    }
}
