<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Yajra\DataTables\DataTables;

class LogController extends Controller
{

    function index()
    {
        if (\request()->ajax()) {
            $events = Log::all();
            return  DataTables::of($events)
                ->addIndexColumn()
                ->addColumn('dt', function ($event) {
                    return $event->created_at->format('Y-m-d h:i:s');
                })
                ->addColumn('user', function ($event) {
                    return $event->user ? $event->user->userable->fullname : 'Inactive';
                })
                ->make(true);
        }
        return view('events.index');
    }

    /*
    public function index()
    {
        return view('events.index', [
            'events' => Log::orderByDesc('created_at')->paginate(200),
        ]);
    }*/
}
