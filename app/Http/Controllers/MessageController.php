<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('to_id', $user->id)->orWhere('to_id', 0)->
        where('message_type', 'text')->
        where('datetime_end', '>=', date("Y-m-d H:i:s"))->
        where('datetime_start', '<=', date("Y-m-d H:i:s"))->
        orderByDesc('datetime_start')->get();

        return view('messages.index', [
            'messages' => $messages,
            'users' => User::teachers(),
        ]);
    }

    public function createAdmin()
    {
        return view('messages.create_sys', [
            'users' => User::teachers(),
        ]);
    }


    public function store(Request $request)
    {
        Message::create([
            'from_id' => $request->from_id ?? Auth::id(), 
            'to_id' => $request->to_id ?? Auth::id(),
            'message_type' => $request->message_type,
            'content' => $request->content,
            'created_at' => date("Y-m-d H:i:s"),
            'datetime_start' => $request->datetime_start ?? date("Y-m-d H:i:s"),
            'datetime_end' => $request->datetime_end ?? '2100-01-01',
        ]);
        return redirect()->route('messages.index');
    }

    public function destroy(Message $message)
    {
        if ($message->from_id == Auth::id() or $message->to_id == Auth::id()) {
            $message->delete();
        }
        return redirect()->route('messages.index');
    }
}
