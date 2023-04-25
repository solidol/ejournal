<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absent;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use DateTime;
use DatePeriod;
use DateInterval;

class AbsentController extends Controller
{
    static $mothStrings = [
        '01' => 'Січень',
        '02' => 'Лютий',
        '03' => 'Березень',
        '04' => 'Квітень',
        '05' => 'Травень',
        '06' => 'Червень',
        '07' => 'Липень',
        '08' => 'Серпень',
        '09' => 'Вересень',
        '10' => 'Жовтень',
        '11' => 'Листопад',
        '12' => 'Грудень',
    ];

    private static function getYear()
    {
        $date = new DateTime();
        $m = $date->format('m');
        switch ($m) {
            case '01':
            case '02':
            case '03':
            case '04':
            case '05':
            case '06':
                return $date->format('Y') - 1;
                break;
            case '08':
            case '09':
            case '10':
            case '11':
            case '12':
                return $date->format('Y');
                break;
            default:
                return $date->format('Y');
                break;
        }
    }

    function studentTable($year = false, $month = false)
    {
        if (!$year || !$month) {
            $year = (new DateTime())->format('Y');
            $month = (new DateTime())->format('m');
        }
        $user = Auth::user();
        $dateFrom = new DateTime($year . '-' . $month . '-01');
        $dateTo = (new DateTime($year . '-' . $month . '-01'))->modify('first day of next month');
        $period = new DatePeriod(
            $dateFrom,
            new DateInterval('P1D'),
            $dateTo
        );

        $dates = array();
        foreach ($period as $dItem) {

            $tmp['raw'] = $dItem;
            $tmp['dw'] = $dItem->format('w');
            $dates[] = $tmp;
        }

        $journals = $user->userable->group->journals()->with('subject')->get()->sortBy('subject.subject_name');
        return view(
            'student.timesheet_show',
            [
                'user' => $user,
                'data' => [
                    'title1' => 'Пропуски за ' . AbsentController::$mothStrings[$month] . ' ' . $year . 'p.',
                    'last_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('last month')->format('m'),
                    'next_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('next month')->format('m'),
                ],
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'arDates' => $dates,
                'journals' => $journals,
                'year' => AbsentController::getYear(),
            ]
        );
    }

    function store($id, Request $request)
    {
        $lesson = Lesson::find($id);
        $searchKeys['kod_lesson'] = $lesson->id;
        Absent::where($searchKeys)->delete();
        foreach ($request->abs as $key => $value) {
            if (!empty($value)) {
                $updateKeys['kod_lesson'] = $lesson->id;
                $updateKeys['kod_prepod'] = $lesson->journal->teacher_id;
                $updateKeys['kod_subj'] = $lesson->journal->subject_id;
                $updateKeys['kod_grup'] = $lesson->journal->group_id;
                $updateKeys['kod_stud'] = $key;
                $updateKeys['data_'] = $lesson->data_;
                $updateKeys['nom_pari'] = $lesson->nom_pari;
                $updateKeys['pricina'] = 'test';
                Absent::insert($updateKeys);
            }
        }
        return redirect()->route('show_lesson', ['id' => $lesson->id]);
    }
}
