<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    //
    protected $table = 'ocenki';

    public static function filterOc($prep, $subj, $group, $control)
    {
        return Marks::join('spisok_stud', 'ocenki.kod_stud', '=', 'spisok_stud.kod_stud')->
        where('kod_prep', $prep)->
        where('ocenki.kod_grup', $group)->
        where('ocenki.kod_subj', $subj)->
        where('vid_kontrol', $control)->get();
    }

    public static function getControls($prep, $subj, $group)
    {
        return Marks::where('kod_prep', $prep)->
        where('kod_grup', $group)->
        where('kod_subj', $subj)->
        select('vid_kontrol')->
        distinct()->get();
    }

    public static function getOcTable($prep, $subj, $group)
    {
        $controls = Marks::getControls($prep, $subj, $group);
        
        $res = array();
        $i=1;
        foreach ($controls as $cItem) {
            $arTmp=array();
            $arTmp['meta']['title']=$cItem->vid_kontrol;
            $arTmp['meta']['slug']='tab-id'.$i;
            $arTmp['data'] = Marks::filterOc($prep, $subj, $group, $cItem->vid_kontrol);
            $res[]=$arTmp;
            $i++;
        }
        //var_dump($res);
        return $res;
    }
}
