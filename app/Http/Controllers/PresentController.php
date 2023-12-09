<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Present;
use Illuminate\Support\Facades\Auth;

class PresentController extends Controller
{
    public function store(Request $request)
    {
        $present = Present::updateOrCreate(
            [
                'lesson_id' => $request->lesson_id,
                'student_id' => Auth::user()->userable_id
            ],
            [
                'present' => 1
            ]
        );
        if (\request()->ajax()) {
            return response()->json(['status' => $present]);
        } else {
            return redirect($request->getRequestUri());
        }
    }
}
