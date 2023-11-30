<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LessonSheduleController extends Controller
{
    public function replacements($count=1){
        $replacements = DB::connection('mysql2')->
        table("b_iblock_element")->
        where('IBLOCK_SECTION_ID',184)->
        orderByDesc('ID')->
        offset(0)->
        limit($count)->
        get();
        if (\request()->ajax()) {
            return response()->json($replacements);
        }
        return view('lshedule.replacement.show',['replacements'=>$replacements]);
    }
}
