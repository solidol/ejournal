<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{

    use HasFactory;

    public $timestamps = false;

    public function controls()
    {
        return $this->hasMany(Control::class)->orderBy('date_');
    }
    public function practices()
    {
        return $this->hasMany(Practice::class)->orderBy('date_');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('data_');
    }
    public function lessonsDate($from, $to)
    {
        return $this->hasMany(Lesson::class)->whereBetween('data_', [$from, $to])->orderBy('data_');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'kod_grup')->orderBy('nomer_grup');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'kod_subj')->orderBy('subject_name');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'kod_prep');
    }
    public function children()
    {
        return $this->hasMany(Journal::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Journal::class, 'parent_id', 'id');
    }
    public function hasPractices()
    {
        return $this->practices->count() > 0 ? true : false;
    }
}
