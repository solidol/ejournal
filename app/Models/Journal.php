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
        return $this->hasMany(Control::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','kod_grup')->orderBy('nomer_grup');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','kod_subj')->orderBy('subject_name');
    }
}