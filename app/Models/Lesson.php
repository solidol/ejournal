<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mark;
use App\Models\Control;


class Lesson extends Model
{
    protected $table = 'lessons_';
    protected $dates = ['data_'];
    protected $appends = ['id', 'date_formatted', 'student_url'];
    public $timestamps = false;
    protected $primaryKey = 'kod_pari';
    protected $guarded = [];


    public function getIdAttribute()
    {
        return $this->kod_pari;
    }
    public function getDateFormattedAttribute()
    {
        return $this->data_->format('d.m.Y');
    }
    public function getStudentUrlAttribute()
    {
        return URL::temporarySignedRoute(
            'lessons.now.show',
            now()->addMinutes(30),
            ['lesson' => $this]
        );
    }
    public function absents()
    {
        return $this->hasMany(Absent::class, 'kod_lesson');
    }
    public function presents()
    {
        return $this->hasMany(Present::class, 'lesson_id');
    }
    public function absent($student_id)
    {
        return $this->absents->where('kod_stud', $student_id)->first() ?? false;
    }
    public function present($student_id)
    {
        return $this->presents->where('student_id', $student_id)->first() ?? false;
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

    public function hasControl()
    {
        return Control::where('date_', $this->data_)->where('journal_id', $this->journal_id)->count() > 0 ? true : false;
    }

    public function controls()
    {
        return Control::where('date_', $this->data_)->where('journal_id', $this->journal_id)->get();
    }


    public static function getByDate($date, $pnom)
    {
        return Lesson::where('data_', $date)->where('nom_pari', $pnom)->get();
    }

    public function isPresent(Student $student)
    {
        return Present::where('student_id', $student->id)->where('lesson_id', $this->id)->count() > 0 ? true : false;
    }
}
