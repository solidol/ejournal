<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;


class LessonController extends Controller
{
    function list($prep, $subj, $group)
    {
        $additionalData = Lesson::getSubjectIfo($prep, $subj, $group)[0];
        return view('lessons', [
            'data' => [
                'title1' => $additionalData->nomer_grup . ' - ' . $additionalData->subject_name,
                'prep' => $prep,
                'subj' => $subj,
                'group' => $group
            ],
            'storeRoute' => route('create_lesson', ['prep' => $prep, 'subj' => $subj, 'group' => $group]),
            'oList' => Lesson::filterLs($prep, $subj, $group),
            'mList' => User::getMySubjects($prep)
        ]);
    }

    public function edit($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        return view(
            'admin.post-create',
            [
                'lesson' => $lesson,
                'route' => 'admin.lesson.update'
            ]
        );
    }
    /*
    public function create($catId)
    {
        $categories = PostCategory::all();
        return view('admin.post-create', [
            'catId' => $catId,
            'categories' => $categories,
            'route' => 'admin.post.store'
        ]);
    }
*/
    public function create(Request $request)
    {


        if ($request->get('lesscode') < 1) {
            $lesson = new Lesson();
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->usercode;
            $lesson->kod_subj = $request->input('sbjcode');
            $lesson->nom_pari = $request->input('lessnom');
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = $request->input('hours');
            $lesson->data_ = $request->input('datetime');
            $lesson->save();
        }

        // redirect

        return redirect()->route('get_lessons', ['prep' => Auth::user()->usercode, 'subj' => $lesson->kod_subj, 'group' => $lesson->kod_grupi]);
    }

    public function update(Request $request)
    {
        if ($request->get('lesscode') < 1) {
            $lesson = Lesson::findOrFail($request->get('lesscode'));
            $lesson->kod_grupi = $request->input('grcode');
            $lesson->kod_prep = Auth::user()->usercode;
            $lesson->kod_subj = $request->input('sbjcode');
            $lesson->nom_pari = $request->input('lessnom');
            $lesson->tema = $request->input('thesis');
            $lesson->zadanaie = $request->input('homework');
            $lesson->kol_chasov = $request->input('hours');
            $lesson->data_ = $request->input('datetime');
            $lesson->save();
        }
        // redirect
        // Session::flash('message', 'Successfully updated post!');
        return redirect()->route('get_lessons', ['prep' => Auth::user()->usercode, 'subj' => $lesson->kod_subj, 'group' => $lesson->kod_grupi]);
        //  }*/
    }

    public function destroy($lessId)
    {
        // delete
        $lesson = Lesson::find($lessId);
        $routeData['subj'] = $lesson->kod_subj;
        $routeData['group'] = $lesson->kod_grupi;
        $lesson->delete();

        return redirect()->route('get_lessons', [
            'prep' => Auth::user()->usercode,
            'subj' => $routeData['subj'],
            'group' => $routeData['group']
        ]);;
    }
}
