<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'events' => Log::orderByDesc('created_at')->paginate(200),
        ]);
    }

}
