<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Practice;
use App\Models\Control;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class MarkController extends Controller
{
    public function store(Request $request)
    {
        $control = Control::find($request->control_id);
        if (!$control)
            $control = Practice::find($request->control_id);
        $ids = [];
        $marks = [];
        foreach ($request->input('marks') as $key => $value) {
            if (!is_numeric($value))
                switch ($value) {
                    case '-':
                    case '':
                        break (2);
                    case 'Н/А':
                    case 'НА':
                    case 'н/а':
                    case 'на':
                    case 'n':
                    case 'na':
                        $value = -1;
                        break;
                    case 'З':
                    case 'з':
                    case 'Зар':
                    case 'зар':
                    case 'z':
                    case 'zar':
                    case 'ON':
                    case 'on':
                        $value = -2;
                        break;
                    default:
                        break (2);
                }

            $searchKeys['control_id'] = $control->id;
            $searchKeys['kod_stud'] = $key;

            $updateKeys['ocenka'] = $value;

            if ($mark = Mark::where($searchKeys)->first()) {
                $mark->ocenka = $value;
                $mark->save();
                $ids[] = $mark->id;
                $marks[] = $mark->mark_str;
            } else if (!is_null($value)) {
                $searchKeys['kod_prep'] = $control->journal->teacher_id;
                $searchKeys['kod_subj'] = $control->journal->subject_id;
                $searchKeys['kod_grup'] = $control->journal->group_id;
                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $control->date_;
                $searchKeys['vid_kontrol'] = $control->title;
                $searchKeys['type_kontrol'] = $control->type_;
                $searchKeys['journal_id'] = $control->journal_id;
                $mark = new Mark($searchKeys);
                $mark->save();
                $ids[] = $mark->id;
                $marks[] = $mark->mark_str;
            }
        }
        if (\request()->ajax()) {
            if (!empty($marks)) {
                return response()->json([
                    'status' => 'ok',
                    'status_text' => 'Виконано успішно',
                    'marks' => $marks,
                    'ids' => $ids,
                ]);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'status_text' => 'Нічого не оновлено',
                ]);
            }
        } else {
            switch ($request->control_type) {
                case 'control':
                    return redirect()->route('controls.show', ['control' => $control]);
                    break;
                case 'practice':
                    return redirect()->route('practices.show', ['control' => $control]);
                    break;
                default:
                    return redirect()->route('controls.show', ['control' => $control]);
                    break;
            }
        }
    }

}
