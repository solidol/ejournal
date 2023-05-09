<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\Control;
use Illuminate\Support\Facades\Auth;

//use \PhpOffice\PhpWord\TemplateProcessor;
use Session;

class ControlController extends Controller
{
    static $monthStrings = [
        '01' => 'січня',
        '02' => 'лютого',
        '03' => 'березня',
        '04' => 'квітня',
        '05' => 'травня',
        '06' => 'червня',
        '07' => 'липня',
        '08' => 'серпня',
        '09' => 'вересня',
        '10' => 'жовтня',
        '11' => 'листопада',
        '12' => 'грудня',
    ];
    function apiShow($id)
    {
        $info = Control::find($id);
        if (!$info->date_) $info->date_ = "2000-01-01";
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

        Session::flash('message', 'Контроль ' . $control->title . ' успішно створено!');
        return redirect()->route('show_control', ['journal_id' => $control->journal->id, 'control_id' => $control->id]);

        //return redirect()->route('get_marks', ['id' => $journal->id]);
    }


    function show($journal_id, $control_id)
    {
        $control = Control::find($control_id);
        if ($control != null && $control->journal_id == $journal_id) {

            $journals = Auth::user()->userable->journals()->with('group')->get()->sortBy('group.title');
            return view('teacher.control_show', [
                'lesson' => false,
                'currentJournal' => $control->journal,
                'journals' => $journals,
                'currentControl' => $control
            ]);
        } else {
            return view('noelement');
        }
    }


    function delete($id)
    {
        $control = Control::find($id);
        Session::flash('message', 'Контроль ' . $control->title . ' успішно видалено!');
        $journal_id = $control->journal_id;
        $control->marks()->delete();
        $control->marksHeader()->delete();
        $control->delete();
        return redirect()->route('get_marks', ['id' => $journal_id]);
    }

    function update(Request $request)
    {
        if ($request->control_id < 1) {
            Session::flash('error', 'Контроль не оновлено! Не вистачає даних!');
            return redirect()->route('get_journals');
        }
        $control = Control::find($request->control_id);
        $control->update([
            'title' => $request->title,
            'date_' => $request->edited_date,
            'type_' => $request->typecontrol,
            'max_grade' => $request->max_grade,
        ]);
        $control->marks()->update([
            'vid_kontrol' => $request->title,
            'data_' => $request->edited_date,
            'type_kontrol' => $request->typecontrol
        ]);
        $control->marksHeader()->update([
            'vid_kontrol' => $request->title,
            'data_' => $request->edited_date,
            'type_kontrol' => $request->typecontrol,
            'ocenka' => $request->max_grade,
        ]);
        return redirect()->route('show_control', ['journal_id' => $control->journal->id, 'control_id' => $control->id]);
        //return redirect()->route('get_marks', ['id' => $control->journal_id]);
    }

    function getExamReport($id)
    {
        $control = Control::find($id);



        $word = new PhpOffice\PhpWord\TemplateProcessor('exam_report_1.docx');


        $word->setValue('teacher', Auth::user()->userable->fullname);
        $word->setValue('group', $control->journal->group->title);
        $word->setValue('subject', $control->journal->subject->title);
        $word->setValue('day', $control->date_->format('d'));
        $word->setValue('month', ControlController::$monthStrings[$control->date_->format('m')]);
        $word->setValue('year', $control->date_->format('Y'));
        $word->setValue('hours', $control->journal->lessons->sum('kol_chasov'));
        $values = array();

        $id = 1;
        $cnt_a = $cnt_b = $cnt_c = $cnt_d = $cnt_e = $cnt_f = $cnt_fx = 0;
        $countYak = 0;
        $countUsp = 0;
        $studentsCount = $control->journal->group->students->count();
        foreach ($control->journal->group->students as $student) {
            $mark = $control->mark($student->id)->mark_str ?? '';

            if ($mark < 0) {
                $nat = 'НА';
                $ects = 'НА';
                $cnt_f++;
            }
            if ($mark >= 0 && $mark < 30) {
                $nat = 'Не задовільно';
                $ects = 'F';
                $cnt_f++;
            }
            if ($mark >= 30 && $mark < 60) {
                $nat =  'Не задовільно';
                $ects = 'FX';
                $cnt_fx++;
            }
            if ($mark >= 60 && $mark < 64) {
                $nat =  'Достатньо';
                $ects = 'E';
                $cnt_e++;
                $countUsp++;
            }
            if ($mark >= 64 && $mark < 75) {
                $nat =  'Задовільно';
                $ects = 'D';
                $cnt_d++;
                $countUsp++;
            }
            if ($mark >= 75 && $mark < 82) {
                $nat =  'Добре';
                $ects = 'C';
                $cnt_c++;
                $countUsp++;
                $countYak++;
            }
            if ($mark >= 82 && $mark < 90) {
                $nat =  'Дуже добре';
                $ects = 'B';
                $cnt_b++;
                $countUsp++;
                $countYak++;
            }
            if ($mark >= 90 && $mark <= 100) {
                $nat =  'Відмінно';
                $ects = 'A';
                $cnt_a++;
                $countUsp++;
                $countYak++;
            }

            $values[] = [
                'id' => $id,
                'fullname' => $student->fullname,
                'nat' => $nat ?? '',
                'hd' => $mark,
                'ects' => $ects ?? '',
            ];

            $id++;
        }
        $usp = round(1000 * $countUsp / $studentsCount) / 10;
        $yak = round(1000 * $countYak / $studentsCount) / 10;
        $word->cloneRowAndSetValues('id', $values);


        $word->setValue('cnt_a', $cnt_a);
        $word->setValue('cnt_b', $cnt_b);
        $word->setValue('cnt_c', $cnt_c);
        $word->setValue('cnt_d', $cnt_d);
        $word->setValue('cnt_e', $cnt_e);
        $word->setValue('cnt_f', $cnt_f);
        $word->setValue('cnt_fx', $cnt_fx);
        $word->setValue('yak', $yak);
        $word->setValue('usp', $usp);



        $word->saveAs('MyWordFile.docx');

        return   response()->download('MyWordFile.docx', $control->journal->group->title . ' ' . $control->journal->subject->title . '.docx');
    }
}
