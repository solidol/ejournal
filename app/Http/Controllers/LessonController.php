<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Lesson;
use App\User;


class LessonController extends Controller
{
    function list($prep, $subj, $group){
        $additionalData = Lesson::getSubjectIfo($prep, $subj, $group)[0];
        return view('lessons', [
            'data' => [
                'title1'=> mb_convert_encoding($additionalData->nomer_grup.' - '.$additionalData->subject_name, "utf-8", "windows-1251") ,    
                'prep'=>$prep, 
                'subj'=>$subj, 
                'group'=>$group
            ],
            'storeRoute' => route('create_lesson',['prep'=>$prep, 'subj'=>$subj, 'group'=>$group]),
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
    public function store(Request $request)
    {
        /*
          // validate
          // read more on validation at http://laravel.com/docs/validation
          $rules = array(
          'name' => 'required',
          'email' => 'required|email',
          'shark_level' => 'required|numeric'
          );
          $validator = Validator::make(Input::all(), $rules);

          // process the login
          if ($validator->fails()) {
          return Redirect::to('sharks/create')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
          } else {
          // store
          $shark = new shark;
          $shark->name = Input::get('name');
          $shark->email = Input::get('email');
          $shark->shark_level = Input::get('shark_level');
          $shark->save();

          // redirect
          Session::flash('message', 'Successfully created shark!');
          return Redirect::to('sharks');
          }

         */
        $lesson = new Lesson();
        $lesson->kod_grupi = $request->input('grcode');
        $lesson->kod_prep = Auth::user()->usercode;
        $lesson->kod_subj = $request->input('sbjcode');
        $lesson->nom_pari = $request->input('lessnom');
        $lesson->tema = mb_convert_encoding($request->input('thesis'), "windows-1251", "utf-8");
        $lesson->zadanaie = mb_convert_encoding($request->input('homework'), "windows-1251", "utf-8");
        $lesson->kol_chasov = $request->input('hours');
        $lesson->data_ = $request->input('datetime');


 
        $lesson->save();

        // redirect
        // Session::flash('message', 'Successfully updated post!');
        return redirect()->route('get_lessons',['prep'=>Auth::user()->usercode,'subj'=>$lesson->kod_subj,'group'=>$lesson->kod_grupi]);
    }

    public function update(Request $request)
    {
        /*
         * 
         * 
         * 
         *             $table->id();
          $table->timestamps();
          $table->string('title');
          $table->string('slug');
          $table->text('description')->nullable();
          $table->text('alterpreview')->nullable();
          $table->text('content');
          $table->unsignedBigInteger('user_id');
          $table->foreign('user_id')->references('id')->on('users');
          $rules = array(
          'title' => 'required',
          'slug' => 'required|email',
          'shark_level' => 'required|numeric'
          );
          $validator = Validator::make(Input::all(), $rules);

          // process the login
          if ($validator->fails()) {
          return Redirect::to('sharks/' . $id . '/edit')
          ->withErrors($validator)
          ->withInput(Input::except('password'));
          } else { */
        // store
        /*
        $lesson = Post::findOrFail($request->input('id'));
        $lesson->title = $request->input('title');
        $lesson->slug = $request->input('slug');
        $lesson->description = $request->input('description');
        $lesson->alterpreview = $request->input('alterpreview');
        $lesson->content = $request->input('content');
        $lesson->post_category_id = $request->input('category_id');

        $lesson->save();

        // redirect
        // Session::flash('message', 'Successfully updated post!');
        return redirect()->route('admin.post.show', ['postId' => $request->input('id')]);
        //  }*/
    }

    public function destroy($lessId)
    {
        // delete
        $lesson = Lesson::find($lessId);
        $routeData['subj']=$lesson->kod_subj;
        $routeData['group']=$lesson->kod_grupi; 
        $lesson->delete();

        return redirect()->route('get_lessons',[
            'prep'=>Auth::user()->usercode,
            'subj'=>$routeData['subj'],
            'group'=>$routeData['group']
        ]);;
    }
}
