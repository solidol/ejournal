<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Journal;
use App\Models\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DatePeriod;
use DateInterval;

class CuratorController extends Controller
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
    function absents($id, $year = false, $month = false)
    {
        $student = Student::find($id);
        if ($student->group->curator->id == Auth::user()->userable->id) {
            if (!$year || !$month) {
                $year = (new DateTime())->format('Y');
                $month = (new DateTime())->format('m');
            }
            $user = $student->user;
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

            $journals = $student->group->journals()->with('subject')->get()->sortBy('subject.subject_name');
            return view(
                'curator.timesheet_show',
                [
                    'student' => $student,
                    'data' => [
                        'title1' => 'Пропуски за ' . CuratorController::$mothStrings[$month] . ' ' . $year . 'p.',
                        'last_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('last month')->format('m'),
                        'next_mon' => (new DateTime($year . '-' . $month . '-01'))->modify('next month')->format('m'),
                    ],
                    'dateFrom' => $dateFrom,
                    'dateTo' => $dateTo,
                    'arDates' => $dates,
                    'journals' => $journals,
                    'year' => CuratorController::getYear(),
                ]
            );
        } else {
            return view('noelement');
        }
    }

    function studList($group_id = false)
    {
        if ($group_id) {
            $students = Student::where('kod_grup', $group_id)->get();
        } else {
            $students = Auth::user()->userable->curLocalStudents;
        }
        $groups = Auth::user()->userable->groups;
        return view('curator.students_list', [
            'students' => $students,
            'groups' => $groups
        ]);
    }

    function marks($id, $journal_id = false)
    {
        $student = Student::find($id);
        if ($student->group->curator->id == Auth::user()->userable->id) {
            if ($journal_id) {
                $journal = Journal::find($journal_id);
            } else {
                $journal = false;
            }
            if ($journal == null) {
                $journal = false;
            }
            $journals = $student->group->journals()->with('subject')->get()->sortBy('subject.subject_name');
            return view('curator.student_marks_show', [
                'student' => $student,
                'lesson' => false,
                'currentJournal' => $journal,
                'journals' => $journals
            ]);
        } else {
            return view('noelement');
        }
    }

    function profile($id)
    {
        $student = Student::find($id);
        if ($student->group->curator->id == Auth::user()->userable->id) {
            $logs = Log::where('user_id', $student->user->id)->get();
            return view('curator.student_profile', [
                'student' => $student,
                'logs' => $logs
            ]);
        } else {
            return view('noelement');
        }
    }
}
