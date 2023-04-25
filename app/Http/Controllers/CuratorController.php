<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Journal;
use App\Models\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuratorController extends Controller
{
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
