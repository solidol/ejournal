<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Lesson;

class Absent extends Model
{
    //use HasFactory;
    protected $table = 'vidsutni';
    protected $primaryKey = 'kod';
    public $timestamps = false;
    protected $guarded = [];
    protected $appends = ['id'];

    public function getIdAttribute()
    {
        return $this->kod;
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'kod_stud');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'kod_pari');
    }



}
