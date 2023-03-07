<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Control;
use Illuminate\Support\Facades\Auth;
use Session;

class ControlController extends Controller
{
    function apiShow($id)
    {
        $info = Mark::getControlInfo($subj, $group, $control);
        if (!$info->data_) $info->data_ = "2000-00-00";
        return response()->json($info);
    }

    function store(Request $request)
    {
        if ($request->journal_id < 1) {
            Session::flash('error', 'Контроль не створено! Не вистачає даних!');
            return redirect()->route('get_journals');
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

        if ($journal->controls()->where('title', $request->title)->get()->first()) {
            Session::flash('error', 'Контроль вже існує!');
            return redirect()->route('get_marks', ['id' => $journal->id]);
        }
        $control = $journal->controls()->create([
            'date_' => $request->date_control,
            'title' => $request->title,
            'max_grade' => $maxval,
            'type_' => $request->control_type,
            'description' => $request->description
        ]);
        $control->marks()->create([
            'kod_prep' => $journal->teacher_id,
            'kod_subj' => $journal->subject_id,
            'kod_grup' => $journal->group_id,
            'kod_stud' => 0,
            'data_' => $control->date_,
            'vid_kontrol' => $control->title,
            'ocenka' => $maxval,
        ]);
        
        Session::flash('message', 'Контроль '.$control->title.' успішно створено!');
        return redirect()->route('get_marks', ['id' => $journal->id]);
    }

    
    function delete($id)
    {
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $subj)->where('kod_grup', $group)->where('vid_kontrol', $control)->delete();
        return redirect()->route('get_marks', ['subj' => $subj, 'group' => $group]);
    }

    function update($id, Request $request)
    {
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $request->input('sbjcode'))->where('kod_grup', $request->input('grcode'))->where('vid_kontrol', $request->input('oldcontrol'))->where('kod_stud', '>', 0)->update(
            [
                'vid_kontrol' => $request->input('control'),
                'data_' => $request->input('datetime2'),
                'type_kontrol' => $request->input('typecontrol')
            ]
        );
        Mark::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $request->input('sbjcode'))->where('kod_grup', $request->input('grcode'))->where('vid_kontrol', $request->input('oldcontrol'))->where('kod_stud', 0)->update(
            [
                'vid_kontrol' => $request->input('control'),
                'data_' => $request->input('datetime2'),
                'ocenka' => $request->input('maxval'),
                'type_kontrol' => $request->input('typecontrol')
            ]
        );
        return redirect()->route('get_marks', ['subj' => $request->input('sbjcode'), 'group' => $request->input('grcode')]);
    }
}
