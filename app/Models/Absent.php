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

    public function student()
    {
        return $this->belongsTo(GStudentroup::class, 'kod_stud');
    }

    public static function listBy($date, $subj, $group, $lessonNo)
    {
        return Absent::where('kod_prepod', Auth::user()->userable_id)->where('kod_subj', $subj)->where('kod_grup', $group)->where('data_', $date)->get();
    }

    public static function listByLesson($lessonId)
    {

        $lessonInfo = Lesson::find($lessonId);

        return Student::where('kod_grup', $lessonInfo->kod_grupi)->orderBy('FIO_stud')->get();
        /*
        return DB::table('spisok_stud')->select(
            'spisok_stud.kod_stud',
            'spisok_stud.kod_grup',
            'spisok_stud.FIO_stud',
            'vidsutni.data_',
            'vidsutni.kod_prepod',
            'vidsutni.kod_subj',
            'vidsutni.nom_pari',
            'vidsutni.kod_lesson',
            DB::raw('DATE_FORMAT(vidsutni.data_,"%d.%m.%y") as dateFormatted'),
            DB::raw("$lessonId as lesson_id")
        )->leftJoinSub(
            Absent::select('kod_stud', 'kod_prepod', 'kod_subj', 'nom_pari', 'kod_lesson', 'data_')->where('kod_prepod', Auth::user()->userable_id)->where('kod_lesson', $lessonId),
            'vidsutni',
            function ($join) {
                $join->on('vidsutni.kod_stud', '=', 'spisok_stud.kod_stud');
            }
        )->where('spisok_stud.kod_grup', $lessonInfo->kod_grupi)->orderBy('FIO_stud')->get();
*/
    }

}
