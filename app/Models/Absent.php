<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Absent extends Model
{
    //use HasFactory;
    protected $table = 'vidsutni';
    protected $primaryKey = 'kod';
    public $timestamps = false;

    public static function listBy($date, $subj, $group, $lessonNo){
        return Absent::
        where('kod_prepod',Auth::user()->usercode)->
        where('kod_subj',$subj)->
        where('kod_grup',$group)->
        where('data_',$date)->get();
    }

    public static function listByLesson($lessonId){

        return DB::table('spisok_stud')->select(
            'vidsutni.kod_stud',
            'spisok_stud.kod_grup',
            'spisok_stud.FIO_stud',
            'vidsutni.data_',
            'vidsutni.kod_prepod',
            'vidsutni.kod_subj',
            'vidsutni.nom_pari',
            'vidsutni.kod_lesson',
            DB::raw('DATE_FORMAT(vidsutni.data_,"%d.%m.%y") as dateFormatted')
        )->leftJoinSub(
            Absent::select('kod_stud','kod_prepod', 'kod_subj', 'nom_pari', 'kod_lesson', 'data_')->
            //where('kod_prep', Auth::user()->usercode)->
            where('kod_lesson',$lessonId),
            'vidsutni',
            function ($join) {
                $join->on('vidsutni.kod_stud', '=', 'spisok_stud.kod_stud');
            }
        )->orderBy('FIO_stud')->get();


/*

        return Absent::
        //where('kod_prepod',Auth::user()->usercode)->
        where('kod_lesson',$lessonId)->
        join('')
        get();
        */
    }


}
