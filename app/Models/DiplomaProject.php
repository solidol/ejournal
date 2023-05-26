<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DiplomaProject extends Model
{
    use HasFactory;
    protected $dates = ['reporting_date'];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'kod_stud');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'kod_prep');
    }
    public function projecting()
    {
        return $this->belongsTo(DiplomaProjecting::class, 'diploma_projecting_id');
    }
}
