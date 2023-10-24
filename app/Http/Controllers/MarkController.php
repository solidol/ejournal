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


    function storeControl(Request $request, Control $control)
    {
        foreach ($request->input('marks') as $key => $value) {
            switch ($value) {
                case 'Н/А':
                case 'НА':
                case 'н/а':
                case 'на':
                    $value = -1;
                    break;
                case 'З':
                case 'з':
                case 'Зар':
                case 'зар':
                case 'ON':
                case 'on':
                    $value = -2;
                    break;
                default:
                    break;
            }

            $searchKeys['control_id'] = $control->id;
            $searchKeys['kod_stud'] = $key;

            $updateKeys['ocenka'] = $value;

            if ($mark = Mark::where($searchKeys)->first()) {
                $mark->ocenka = $value;
                $mark->save();
            } else if (!is_null($value)) {
                $searchKeys['kod_prep'] = $control->journal->teacher_id;
                $searchKeys['kod_subj'] = $control->journal->subject_id;
                $searchKeys['kod_grup'] = $control->journal->group_id;
                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $control->date_;
                $searchKeys['vid_kontrol'] = $control->title;
                $searchKeys['type_kontrol'] = $control->type_;
                $searchKeys['journal_id'] = $control->journal_id;
                Mark::insert($searchKeys);
            }
        }

        return redirect()->route('controls.show', ['control' => $control]);
    }

    function storePractice(Request $request, Practice $practice)
    {
        foreach ($request->input('marks') as $key => $value) {
            switch ($value) {
                case 'Н/А':
                case 'НА':
                case 'н/а':
                case 'на':
                    $value = -1;
                    break;
                case 'З':
                case 'з':
                case 'Зар':
                case 'зар':
                case 'ON':
                case 'on':
                    $value = -2;
                    break;
                default:
                    break;
            }

            $searchKeys['control_id'] = $practice->id;
            $searchKeys['kod_stud'] = $key;

            $updateKeys['ocenka'] = $value;

            if ($mark = Mark::where($searchKeys)->first()) {
                $mark->ocenka = $value;
                $mark->save();
            } else if (!is_null($value)) {
                $searchKeys['kod_prep'] = $practice->journal->teacher_id;
                $searchKeys['kod_subj'] = $practice->journal->subject_id;
                $searchKeys['kod_grup'] = $practice->journal->group_id;
                $searchKeys['ocenka'] = $value;
                $searchKeys['data_'] = $practice->date_;
                $searchKeys['vid_kontrol'] = $practice->title;
                $searchKeys['type_kontrol'] = $practice->type_;
                $searchKeys['journal_id'] = $practice->journal_id;
                Mark::insert($searchKeys);
            }
        }

        return redirect()->route('practices.show', ['practice' => $practice]);
    }
}
