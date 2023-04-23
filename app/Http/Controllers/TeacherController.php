<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function avatar($id){
            $teacher = Teacher::find($id);
            if ($teacher->image && Storage::disk('public')->exists($teacher->image))
                return Storage::disk('public')->download($teacher->image);

                return Storage::disk('public')->download('system/np_n.jpg');

    }
}
