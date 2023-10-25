<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Control;
use App\Models\Group;
use App\Models\Practice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PracticeController extends Controller
{
    function index($id)
    {
        $journal = Auth::user()->userable->journals->find($id);
        if ($journal == null)
            return view('noelement');
        return view('practices.index', [
            'lesson' => false,
            'currentJournal' => $journal,
            'journals' => Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title')
        ]);
    }

    function show(Practice $practice)
    {
        if (\request()->ajax()) {
            if (!$practice->date_) $practice->date_ = "2000-01-01";
            return response()->json($practice);
        }

        if ($practice->journal->teacher_id == Auth::user()->userable_id) 
        {

            $journals = Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title');
            return view('practices.show', [
                'lesson' => false,
                'currentJournal' => $practice->journal,
                'journals' => $journals,
                'currentControl' => $practice
            ]);
        } else {
            return view('noelement');
        }
    }

    function store(Request $request)
    {
        if ($request->journal_id < 1) {
            Session::flash('error', 'Контроль не створено! Не вистачає даних!');
            return redirect()->route('journals.index');
        }
        $journal = Journal::find($request->journal_id);
        $maxval = $request->maxval;
        switch ($maxval) {

            case 'З':
            case 'з':
            case 'Зар':
            case 'зар':
                $maxval = -2;
                break;
            default:
                break;
        }
        if (!is_numeric($maxval)) $maxval = 0;

        if ($journal->practices()->where('title', $request->title)->get()->first()) {
            Session::flash('error', 'Контроль вже існує!');
            return redirect()->route('practices.index', ['id' => $journal->id]);
        }
        $control = $journal->practices()->create([
            'date_' => $request->date_control,
            'title' => $request->title,
            'max_grade' => $maxval,
            'type_' => $request->control_type,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id??0,
        ]);
        $control->marks()->create([
            'kod_prep' => $journal->teacher_id,
            'kod_subj' => $journal->subject_id,
            'kod_grup' => $journal->group_id,
            'kod_stud' => 0,
            'data_' => $control->date_,
            'vid_kontrol' => $control->title,
            'type_kontrol' => $request->control_type,
            'ocenka' => $maxval,
            'journal_id' => $journal->id,
        ]);

        Session::flash('message', 'Контроль ' . $control->title . ' успішно створено!');
        return redirect()->route('practices.show', ['practice' => $control]);
    }

    function destroy(Practice $practice)
    {
        Session::flash('message', 'Контроль ' . $practice->title . ' успішно видалено!');
        $journal_id = $practice->journal_id;
        $practice->marks()->delete();
        $practice->marksHeader()->delete();
        $practice->delete();
        return redirect()->route('practices.index', ['id' => $journal_id]);
    }

    function update(Request $request)
    {
        if ($request->control_id < 1) {
            Session::flash('error', 'Контроль не оновлено! Не вистачає даних!');
            return redirect()->route('journals.index');
        }
        $practice = Practice::find($request->control_id);
        $practice->update([
            'title' => $request->title,
            'date_' => $request->edited_date,
            'type_' => $request->control_type,
            'max_grade' => $request->max_grade,
        ]);
        $practice->marks()->update([
            'vid_kontrol' => $request->title,
            'data_' => $request->edited_date,
            'type_kontrol' => $request->control_type
        ]);
        $practice->marksHeader()->update([
            'vid_kontrol' => $request->title,
            'data_' => $request->edited_date,
            'type_kontrol' => $request->control_type,
            'ocenka' => $request->max_grade,
        ]);
        return redirect()->route('practices.show', ['practice' => $practice]);
    }
}
