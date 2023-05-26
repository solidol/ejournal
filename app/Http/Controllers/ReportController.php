<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaProject;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use NCL\NCLNameCaseUa;

class ReportController extends Controller
{
    public static function getShortName($name){
        $name = explode(' ',trim($name," "));
        $shortname = $name[0]." ".mb_substr($name[1], 0, 1).".".mb_substr($name[2], 0, 1).".";
        return $shortname;
    }
    public static function getShortNameReverse($name){
        $name = explode(' ',trim($name," "));
        $shortname = mb_substr($name[1], 0, 1).".".mb_substr($name[2], 0, 1).". ".$name[0];
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
        $word->setValue('student_fullname_1', $dp->student->fullname);
        $word->setValue('student_fullname_2', $nc->q($dp->student->fullname, 2));
        $word->setValue('student_shortname_1', $dp->student->shortname);
        $word->setValue('project_title', $dp->title);
        $word->setValue('teacher_fullname', $dp->teacher->fullname);
        $word->setValue('scriber_shortname', $dp->projecting->scriber->shortname_rev);

        $word->setValue('chief_full_1', str_replace(',', '', $dp->projecting->chief));
        $word->setValue('committee_0', $dp->projecting->committee);


        $chief = explode(',', $dp->projecting->chief);
        $committee = explode(',', $dp->projecting->committee);

        $word->setValue('chief_short_1', ReportController::getShortNameReverse(end($chief)));
        $word->setValue('committee_1', ReportController::getShortNameReverse($committee[0]));
        $word->setValue('committee_2', ReportController::getShortNameReverse($committee[1]));
        $word->setValue('committee_3', ReportController::getShortNameReverse($committee[2]));


        $filename = "Протокол захисту " . $dp->projecting->group->title . " " . $dp->student->fullname . '.docx';

        $word->saveAs(Storage::disk('public')->path('reports/diploma') . '/' . $filename);

        return Storage::disk('public')->download('reports/diploma/' . $filename);
    }
}
