<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Journal;
use App\Models\Lesson;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DateTime;

class JournalController extends Controller
{
    function index($group = false)
    {
        $user = Auth::user();
        $groups = DB::table('grups')->orderBy('nomer_grup')->get();
        $subjects = DB::table('subjects')->orderBy('subject_name')->get();
        if (!$group) {
            $journals = $user->userable->journals()->with('group')->get()->sortBy('group.title');
        } else {
            $journals = $user->userable->journals()->where('group_id', $group)->with('group')->get()->sortBy('group.title');
        }
        $messages = Message::where('to_id', 0)
            ->where('message_type', 'text')
            ->whereDate('datetime_end', '>', (new DateTime())->format('Y-m-d h:m:s'))
            ->whereDate('datetime_start', '<', (new DateTime())->format('Y-m-d h:m:s'))
            ->get();

        return view('journals.index', [
            'messages' => $messages,
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
        $journals = Auth::user()->userable->group->journals()->with('subject')->get()->sortBy('subject.subject_name');
        return view('student.marks_show', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => $journals
        ]);
    }

    function show(Journal $journal)
    {
        if ($journal == null)
            return view('noelement');
        if ($journal->teacher_id != Auth::user()->userable_id)
            return view('noelement');

        return view('journals.show', [
            'lesson' => false,
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

        Session::flash('message', 'Журнал створено, першу пару збережено');
        return redirect()->route('lessons.index', ['id' => $journal->id]);
    }

    public function update(Request $request, Journal $journal)
    {

        $journal->group_id = $request->grcode ?? $journal->group_id;
        $journal->subject_id = $request->sbjcode ?? $journal->subject_id;
        $journal->teacher_id = Auth::user()->userable_id;
        $journal->description = $request->description ?? $journal->description;
        $journal->color = $request->color ?? $journal->color;
        $journal->save();

        Session::flash('message', 'Налаштування журналу збережено');
        return redirect()->route('journals.show', ['journal' => $journal]);
    }
}
