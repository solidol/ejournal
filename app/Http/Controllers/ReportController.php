<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProject;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Models\Control;

use NCL\NCLNameCaseUa;

class ReportController extends Controller
{



    public static function getWideMark($mark = 0)
    {
        $nat = 'НА';
        $ects = 'НА';
        if ($mark < 0) {
            $nat = 'НА';
            $ects = 'НА';
        }
        if ($mark >= 0 && $mark < 30) {
            $nat = 'Не задовільно';
            $ects = 'F';
        }
        if ($mark >= 30 && $mark < 60) {
            $nat =  'Не задовільно';
            $ects = 'FX';
        }
        if ($mark >= 60 && $mark < 64) {
            $nat =  'Достатньо';
            $ects = 'E';
        }
        if ($mark >= 64 && $mark < 75) {
            $nat =  'Задовільно';
            $ects = 'D';
        }
        if ($mark >= 75 && $mark < 82) {
            $nat =  'Добре';
            $ects = 'C';
        }
        if ($mark >= 82 && $mark < 90) {
            $nat =  'Дуже добре';
            $ects = 'B';
        }
        if ($mark >= 90 && $mark <= 100) {
            $nat =  'Відмінно';
            $ects = 'A';
        }

        $result = [
            'national' => $nat ?? '',
            'mark' => $mark,
            'ects' => $ects ?? '',
        ];
        return $result;
    }

    public static function getShortName($name)
    {
        $name = explode(' ', trim($name, " "));
        $shortname = $name[0] . " " . mb_substr($name[1], 0, 1) . "." . mb_substr($name[2], 0, 1) . ".";
        return $shortname;
    }
    public static function getShortNameReverse($name)
    {
        $name = explode(' ', trim($name, " "));
        $shortname = mb_substr($name[1], 0, 1) . "." . mb_substr($name[2], 0, 1) . ". " . $name[0];
        return $shortname;
    }




    function getProtoReport($id)
    {

        $nc = new NCLNameCaseUa();

        $dp = DiplomaProject::find($id);

        $word = new TemplateProcessor(Storage::disk('public')->path('system/' . $dp->projecting->template));


        $word->setValue('n', $dp->prot_number . '/' . $dp->prot_subnumber);
        $word->setValue('reporting_date', $dp->reporting_date->format('d.m.Y'));
        $word->setValue('c_n', $dp->projecting->com_number);
        $word->setValue('c_d', $dp->projecting->com_date->format('d.m.Y'));
        $word->setValue('student_fullname_1', $nc->q($dp->student->fullname, 1));
        $word->setValue('student_fullname_2', $nc->q($dp->student->fullname, 2));
        $word->setValue('student_shortname_1', $dp->student->shortname);
        $word->setValue('project_title', $dp->title);
        $word->setValue('teacher_fullname', $nc->q($dp->teacher->fullname, 1));
        //$word->setValue('teacher_fullname', $dp->teacher->fullname);
        $word->setValue('scriber_shortname', $dp->projecting->scriber->shortname_rev);

        $word->setValue('chief_full_1', str_replace(',', '', $dp->projecting->chief));
        $word->setValue('committee_0', $dp->projecting->committee);

        $word->setValue('pages', $dp->pages);
        $word->setValue('minutes', $dp->minutes);
        $word->setValue('slides', $dp->slides);

        $word->setValue('mark_n', ReportController::getWideMark($dp->mark)['national']);
        $word->setValue('mark_ects', $dp->mark.' '.ReportController::getWideMark($dp->mark)['ects']);

        $chief = explode(',', $dp->projecting->chief);
        $committee = explode(',', $dp->projecting->committee);

        $word->setValue('chief_short_1', ReportController::getShortNameReverse(end($chief)));
        $word->setValue('committee_1', ReportController::getShortNameReverse($committee[0]));
        $word->setValue('committee_2', ReportController::getShortNameReverse($committee[1]));
        $word->setValue('committee_3', ReportController::getShortNameReverse($committee[2]));

        $questions = explode("\n", $dp->questions);

        $word->setValue('qa_1', (isset($questions[0]) ? '1. ' . $questions[0] : ''));
        $word->setValue('qa_2', (isset($questions[1]) ? '2. ' . $questions[1] : ''));
        $word->setValue('qa_3', (isset($questions[2]) ? '3. ' . $questions[2] : ''));
        $word->setValue('qa_4', (isset($questions[3]) ? '4. ' . $questions[3] : ''));
        $word->setValue('qa_5', (isset($questions[4]) ? '5. ' . $questions[4] : ''));

        $filename = "Протокол захисту " . $dp->projecting->group->title . " " . $dp->student->fullname . '.docx';

        $word->saveAs(Storage::disk('public')->path('reports/diploma') . '/' . $filename);

        return Storage::disk('public')->download('reports/diploma/' . $filename);
    }


    function getExamReport(Request $request)
    {
        $control = Control::find($request->control_id);



        $word = new TemplateProcessor(Storage::disk('public')->path('system/exam_report_1.docx'));


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
            $nat = 'НА';
            $ects = 'НА';
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

        $filename = $control->journal->group->title . ' ' . $control->journal->subject->title . '.docx';

        $word->saveAs(Storage::disk('public')->path('reports') . '/' . $filename);

        return Storage::disk('public')->download('reports/' . $filename);
    }
}
