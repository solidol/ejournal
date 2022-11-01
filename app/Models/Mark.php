<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Mark extends Model
{
    //
    protected $table = 'ocenki';

    public static function filterOc($subj, $group, $control)
    {
        return Mark::join('spisok_stud', 'ocenki.kod_stud', '=', 'spisok_stud.kod_stud')->
        where('kod_prep', Auth::user()->usercode)->
        where('ocenki.kod_grup', $group)->
        where('ocenki.kod_subj', $subj)->
        where('vid_kontrol', $control)->get();
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
            $arTmp=array();
            $arTmp['meta']['title']=$cItem->vid_kontrol;
            $arTmp['meta']['slug']='tab-id'.$i;
            $arTmp['data'] = Mark::filterOc($subj, $group, $cItem->vid_kontrol);
            $res[]=$arTmp;
            $i++;
        }
        //var_dump($res);
        return $res;
    }
}
