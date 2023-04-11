<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'grups';

    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'kod_grup';
    protected $appends = ['id', 'title'];

    public function getIdAttribute()
    {
        return $this->kod_grup;
    }
    public function getTitleAttribute()
    {
        return $this->nomer_grup;
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'kod_grup', 'kod_grup')->orderBy('FIO_stud');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'kod_grupi', 'kod_grup');
    }
    public function journals()
    {
        return $this->hasMany(Journal::class, 'group_id', 'kod_grup');
    }
    public function curator()
    {
        return $this->belongsTo(Teacher::class, 'kod_prep');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'journals', 'group_id', 'teacher_id')->distinct();
    }
}
