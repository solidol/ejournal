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
            $events = Log::orderBy('created_at', 'desc');
            return  DataTables::of($events)
                ->addIndexColumn()
                ->addColumn('dt', function ($event) {
                    return $event->created_at->format('Y-m-d h:i:s');
                })
                ->addColumn('user', function ($event) {
                    return $event->user->userable ? $event->user->userable->fullname : 'Inactive';
                })
                ->make(true);
        }
        return view('events.index');
    }

}
