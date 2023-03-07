<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Subject;
use App\Models\Absent;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Journal;
use App\Models\Control;
use Session;
use DateTime;
use DatePeriod;
use DateInterval;

class TimesheetController extends Controller
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

    public function getTimesheet()
    {
        $date = new DateTime();
        return redirect()->route('my_timesheet_date', ['year' => $date->format('Y'), 'month' => $date->format('m')]);
    }

    public function getTimesheetDate($year = '2022', $month = '08')
    {
        $user = Auth::user();
        $period = new DatePeriod(
            new DateTime($year . '-' . $month . '-01'),
            new DateInterval('P1D'),
            (new DateTime($year . '-' . $month . '-01'))->modify('first day of next month')
        );

        $dates = array();
        foreach ($period as $dItem) {

            $tmp['raw'] = $dItem;
            $tmp['dw'] = $dItem->format('w');
            $dates[] = $tmp;
        }

        $journals = $user->userable->journals;
        return view(
            'teacher.timesheet_show',
            [

                'data' => [
                    'title1' => 'Табель за ' . LessonController::$mothStrings[$month] . ' ' . $year . 'p.',
                    'last_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('last month')->format('m'),
                    'next_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('next month')->format('m'),
                ],
                'arDates' => $dates,
                'journals' => $journals
            ]
        );
    }
}
