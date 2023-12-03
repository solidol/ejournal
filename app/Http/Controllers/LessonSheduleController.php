<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;

class LessonSheduleController extends Controller
{
    public function replacements($count = 1)
    {
        if ($count > 50)
            $count = 50;
        $replacements = DB::connection('mysql2')->
            table("b_iblock_element")->
            where('IBLOCK_SECTION_ID', 184)->
            orderByDesc('ID')->
            offset(0)->
            limit($count)->
            get();
        if (\request()->ajax()) {
            return response()->json($replacements);
        }
        return view('lshedule.replacement.show', ['replacements' => $replacements]);
    }

    public function checkrep()
    {
        $replacements = DB::connection('mysql2')->
            table("b_iblock_element")->
            select('TIMESTAMP_X', 'NAME')->
            where('IBLOCK_SECTION_ID', 184)->
            orderByDesc('ID')->
            offset(0)->
            limit(1)->
            get();
        if (\request()->ajax()) {
            if (!$replacements)
                abort(404);
            return response()->json($replacements);
        }
        abort(404);
    }

    public function group($group)
    {

        $replacements = DB::connection('mysql2')->
            table("b_iblock_element")->
            where('IBLOCK_SECTION_ID', 185)->
            orderByDesc('ID')->
            offset(0)->
            limit(5)->
            get();
        if (\request()->ajax()) {
            return response()->json($replacements);
        }
        return view('lshedule.replacement.show', ['replacements' => $replacements]);
    }
}
