<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    protected $table = 'lessons_';
    public $timestamps = false;
    protected $primaryKey = 'kod_pari';

    public static function filterLs($subj, $group)
    {
        return Lesson::select('*',DB::raw('DATE_FORMAT(data_,"%d.%m.%y") as date'))->
        where('lessons_.kod_prep', Auth::user()->usercode)->
        where('lessons_.kod_grupi', $group)->
        where('lessons_.kod_subj', $subj)->
        orderBy('lessons_.data_')->get();
    }

    public static function getSubjectInfo($subj, $group)
    {
        return DB::table('subjects')->
        join('lessons_', 'subjects.kod_subj', '=', 'lessons_.kod_subj')->
        join('grups', 'lessons_.kod_grupi', '=', 'grups.kod_grup')->
        select('nomer_grup','kod_grup','subjects.kod_subj', 'subject_name')->
        where('lessons_.kod_prep',Auth::user()->usercode)->
        where('lessons_.kod_subj',$subj)->
        where('lessons_.kod_grupi',$group)->
        distinct()->first();
        
    }

}
