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
    protected $guarded = [];
    //protected $fillable = ['data_','ocenka','kod_prep','kod_subj','kod_grup','kod_stud','vid_kontrol'];
    protected $dates = ['data_'];
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(GStudentroup::class, 'kod_stud');
    }

    public static function getControlInfo($subj, $group, $control)
    {
        return Mark::where('kod_grup', $group)->
        where('kod_prep', Auth::user()->userable_id)->
        where('kod_subj', $subj)->
        where('vid_kontrol', $control)->
        where('kod_stud', 0)->
        first();

    }

    public static function filterOc($subj, $group, $control)
    {



        $marks = DB::table('spisok_stud')->select(
                'spisok_stud.kod_stud',
                'spisok_stud.kod_grup',
                'spisok_stud.FIO_stud',
                'ocenki.ocenka',
                'ocenki.kod_subj',
                'ocenki.vid_kontrol',
                'ocenki.data_',
                DB::raw('DATE_FORMAT(ocenki.data_,"%d.%m.%y") as dateFormatted')
            )->leftJoinSub(
                Mark::select('kod_stud', 'kod_prep', 'kod_grup', 'kod_subj', 'vid_kontrol', 'ocenka', 'data_')->where('kod_grup', $group)->where('kod_prep', Auth::user()->userable_id)->where('kod_subj', $subj)->where('vid_kontrol', $control),
                'ocenki',
                function ($join) {
                    $join->on('ocenki.kod_stud', '=', 'spisok_stud.kod_stud');
                }
            )->where('spisok_stud.kod_grup', $group)->orderBy('FIO_stud')->distinct()->get();

        foreach ($marks as &$mItem) {

            $mItem->kod_prep = Auth::user()->userable_id;
            $mItem->kod_subj = $subj;
            $mItem->vid_kontrol = $control;

            switch ($mItem->ocenka) {
                case -1:
                    $mItem->ocenka = "Н/А";
                    break;
                case -2:
                    $mItem->ocenka = "Зар";
                    break;
                default:
                    break;
            }
        }
        return $marks;
    }

    public static function getControls($subj, $group)
    {
        return Mark::select('vid_kontrol', 'ocenka', 'data_')->
        where('kod_prep', Auth::user()->userable_id)->
        where('kod_grup', $group)->
        where('kod_subj', $subj)->
        where('kod_stud', 0)->
        where('vid_kontrol', '<>', '')->
        //whereNotNull('data_')->
        distinct()->orderBy('data_', 'ASC')->get();
    }

    public static function getControlsByDate($subj, $group, $date)
    {
        return Mark::select('vid_kontrol', 'ocenka', 'data_')->
        where('kod_prep', Auth::user()->userable_id)->
        where('kod_grup', $group)->
        where('data_', $date)->
        where('kod_subj', $subj)->
            where('kod_stud', 0)->
            where('vid_kontrol', '<>', '')->
            distinct()->orderBy('data_', 'ASC')->get();
    }

    public static function getOcTable($subj, $group)
    {

        $controls = Mark::getControls($subj, $group);
        //dd($controls);
        $res = array();
        $i = 1;
        $cl = [];
        foreach ($controls as $cItem) {
            $controlInfo = Mark::getControlInfo($subj, $group, $cItem->vid_kontrol);
            //dd($controlInfo);
            $cl[] = $controlInfo;
            $arTmp = array();
            $arTmp['data'] = Mark::filterOc($subj, $group, $cItem->vid_kontrol);
            
            $arTmp['meta']['title'] = $controlInfo->vid_kontrol ?? 'Undefined';
            $arTmp['meta']['maxval'] = $controlInfo->ocenka ?? 0;
            $arTmp['meta']['group'] = $controlInfo->kod_grup ?? 0;
            $arTmp['meta']['subj'] = $controlInfo->kod_subj ?? 0;
            $arTmp['meta']['slug'] = 'tab-id' . $i;
            $arTmp['meta']['data_'] = $controlInfo->data_ ?? '2000-01-01';//$arTmp['data']->first()->data_;
            $controlInfo->type_kontrol = $controlInfo->type_kontrol >= 0 ? $controlInfo->type_kontrol : -1;
            switch ($controlInfo->type_kontrol) {
                case 0:
                    $arTmp['meta']['typecontrol'] = "Поточний";
                    break;
                case 1:
                    $arTmp['meta']['typecontrol'] = "Модульний";
                    break;
                case 2:
                    $arTmp['meta']['typecontrol'] = "Підсумковий";
                    break;
                default:
                    $arTmp['meta']['typecontrol'] = "-";
                    break;
            }
            $res[] = $arTmp;
            $i++;
        }
        //dd($cl);
        return $res;
    }
}
