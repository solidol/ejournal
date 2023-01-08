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
    public function list()
    {
        $user = Auth::user();
        $messLess = Message::where('to_id', $user->id)->where('message_type', 'lesson')->get();
        $messText = Message::where('to_id', $user->id)->where('message_type', 'text')->get();
        $messAlerts = Message::where('message_type', 'alerts')->where('to_id', $user->id)->orWhere('to_id', 0)->get();
        $messSystem = Message::where('message_type', 'system')->where('to_id', $user->id)->orWhere('to_id', 0)->get();
        foreach ($messLess as &$l) {
            $content = json_decode($l->content);
            $l->content = Lesson::find($content->id);
        }
        return view('teacher.messages', [
            'arLessons' => $messLess,
            'arTexts' => $messText,
            'arAlesrts' => $messAlerts,
            'arSystem' => $messSystem,
            'arUsers' => User::all(),
        ]);
    }
    public function send(Request $request)
    {
        Message::create([
            'from_id' => Auth::user()->id, //$request->from_id;
            'to_id' => $request->user_id,
            'message_type' => $request->message_type,
            'content' => $request->content,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        return redirect()->route('message_index');
    }

    public function shareLesson(Request $request)
    {
        $lesson = Lesson::find($request->lesscode);
        Message::create([
            'from_id' => Auth::user()->id,
            'to_id' => $request->user_id,
            'message_type' => 'lesson',

            'content' => json_encode(['id' => $lesson->kod_pari, 'title' => $lesson->tema]),
            'created_at' => date("Y-m-d H:i:s"),

        ]);
        return redirect()->route('show_lesson', ['lessonId' => $lesson->kod_pari]);
    }

    public function acceptLesson($messId)
    {
        $m =  Message::find($messId);
        $content = json_decode($m->content);
        $lesson = Lesson::find($content->id);


        $newLesson = new Lesson();
        $newLesson->kod_grupi = $lesson->kod_grupi;
        $newLesson->kod_prep = Auth::user()->userable_id;
        $newLesson->kod_subj = $lesson->kod_subj;
        $newLesson->nom_pari = $lesson->nom_pari;
        $newLesson->tema = $lesson->tema;
        $newLesson->zadanaie = $lesson->zadanaie;
        $newLesson->kol_chasov = $lesson->kol_chasov;
        $newLesson->data_ = $lesson->data_;
        $newLesson->save();

        $m->delete();
        Session::flash('message', 'Пару збережено');
        return redirect()->route('get_lessons', ['subj' => $lesson->kod_subj, 'group' => $lesson->kod_grupi]);
    }

    public function deleteLesson($messId)
    {
        Message::find($messId)->delete();
        return redirect()->route('message_index');
    }
}
