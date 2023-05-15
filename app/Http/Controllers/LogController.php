<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        return view('admin.events_list', [
            'arEvents' => Log::orderByDesc('created_at')->paginate(200),
        ]);
    }

}
