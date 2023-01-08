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
    
    public function student()
    {
        return $this->belongsTo(GStudentroup::class, 'kod_stud');
    }

    public static function listBy($date, $subj, $group, $lessonNo)
    {
        return Absent::where('kod_prepod', Auth::user()->userable_id)->where('kod_subj', $subj)->where('kod_grup', $group)->where('data_', $date)->get();
    }



}
