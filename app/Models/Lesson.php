<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mark;


class Lesson extends Model
{
    protected $table = 'lessons_';
    protected $dates = ['data_'];
    protected $appends = ['id'];
    public $timestamps = false;
    protected $primaryKey = 'kod_pari';
    protected $guarded = [];

    public function getIdAttribute()
    {
        return $this->kod_pari;
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'kod_grupi')->orderBy('nomer_grup');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'kod_subj')->orderBy('subject_name');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'kod_prep');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public static function filterLs($subj, $group)
    {
        return Lesson::where('lessons_.kod_prep', Auth::user()->userable_id)->where('lessons_.kod_grupi', $group)->where('lessons_.kod_subj', $subj)->orderBy('lessons_.data_')->get();
    }

    public static function getSubjectInfo($subj, $group)
    {
        return Lesson::where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $subj)->where('kod_grupi', $group)->first();
    }

    public function hasControl()
    {
        $cn = Mark::where('kod_grup', $this->kod_grupi)->where('kod_prep', $this->kod_prep)->where('kod_subj', $this->kod_subj)->where('data_', $this->data_)->count();
        return $cn > 0 ? true : false;
    }
}
