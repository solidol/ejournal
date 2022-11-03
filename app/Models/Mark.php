<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Mark extends Model
{
    //
    protected $table = 'ocenki';
    protected $primaryKey = 'kod_ocenki';
    protected $fillable = ['ocenka'];
    public $timestamps = false;

    public static function getControlInfo($subj, $group, $control){

        return Mark::select('*',DB::raw('DATE_FORMAT(ocenki.data_,"%d.%m.%y") as dateFormatted'))->
        where('kod_grup', $group)->
        where('kod_prep', Auth::user()->usercode)->
        where('kod_subj', $subj)->
        where('vid_kontrol', $control)->
        where('data_','>','0000-00-00')->
        first();

    }

    public static function filterOc($subj, $group, $control)
    {
        
        

        $marks = DB::table('spisok_stud')->
        select('spisok_stud.kod_stud',
            'spisok_stud.kod_grup',
            'spisok_stud.FIO_stud',
            'ocenki.ocenka',
            'ocenki.vid_kontrol',
            'ocenki.data_',
            DB::raw('DATE_FORMAT(ocenki.data_,"%d.%m.%y") as dateFormatted'))->
        leftJoinSub(
            Mark::select('kod_stud', 'kod_prep','kod_subj','vid_kontrol','ocenka','data_')->
            where('kod_grup', $group)->
            
            where('kod_prep', Auth::user()->usercode)->        
            where('kod_subj', $subj)->
            where('vid_kontrol', $control), 'ocenki', function($join){ $join->on('ocenki.kod_stud', '=', 'spisok_stud.kod_stud');}
        )->
        where('spisok_stud.kod_grup',$group)->
        orderBy('FIO_stud')->
        get();

        foreach($marks as &$mItem){
            
            $mItem->kod_prep = Auth::user()->usercode;
            $mItem->kod_subj = $subj;
            $mItem->vid_kontrol = $control;

            switch ($mItem->ocenka){
                case -1: $mItem->ocenka = "Н/А"; break;
                case -2: $mItem->ocenka = "Зар"; break;
                default: break;
            }
            
        }
        return $marks;
    }

    public static function getControls($subj, $group)
    {
        return Mark::where('kod_prep', Auth::user()->usercode)->
        where('kod_grup', $group)->
        where('kod_subj', $subj)->
        select('vid_kontrol')->
        distinct()->get();
    }

    public static function getOcTable($subj, $group)
    {
        
        $controls = Mark::getControls($subj, $group);
        
        $res = array();
        $i=1;
        
        foreach ($controls as $cItem) {
            $controlInfo = Mark::getControlInfo($subj, $group, $cItem->vid_kontrol);
            //dd($controlInfo);
            $arTmp=array();
            $arTmp['meta']['title']=$cItem->vid_kontrol;
            $arTmp['meta']['slug']='tab-id'.$i;
            $arTmp['data'] = Mark::filterOc($subj, $group, $cItem->vid_kontrol);
            $arTmp['meta']['dateFormatted']=$controlInfo->dateFormatted??'';
            $arTmp['meta']['data_']=$controlInfo->data_??$arTmp['data'][0]->data_;
            //dd($controlInfo->dateFormatted);
            $res[]=$arTmp;
            $i++;
        }

        return $res;
    }
}
