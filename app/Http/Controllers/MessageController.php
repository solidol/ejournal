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
        $messText = Message::where('to_id', $user->id)->where('message_type', 'text')->get();
        $messSystem = Message::where('message_type', 'system')->where('to_id', $user->id)->orWhere('to_id', 0)->get();

        return view('messages.index', [
            'arTexts' => $messText,
            'arSystem' => $messSystem,
            'arUsers' => User::all(),
        ]);
    }

    public function createAdmin()
    {
        return view('admin.messages_create', [
            'arUsers' => User::all(),
        ]);
    }


    public function store(Request $request)
    {
        Message::create([
            'from_id' => Auth::user()->id, //$request->from_id;
            'to_id' => $request->user_id,
            'message_type' => $request->message_type,
            'content' => $request->content,
            'created_at' => date("Y-m-d H:i:s"),
            'datetime_start' => date("Y-m-d H:i:s"),
            'datetime_end' => '2100-01-01',
        ]);
        return redirect()->route('messages.index');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('messages.index');
    }
}
