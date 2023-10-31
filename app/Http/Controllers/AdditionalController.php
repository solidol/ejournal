<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additional;

class AdditionalController extends Controller
{


    public function store(Request $request)
    {
        $add = new Additional();
        $add->additionable_type = $request->additionable_type;
        $add->additionable_id = $request->additionable_id;
        $add->title = $request->title;
        $add->description = $request->description??'';
        $add->additional_type = $request->additional_type;
        $add->link = $request->link;
        $add->save();
        return redirect()->back();
    }

    public function destroy(Additional $additional)
    {
        $additional->delete();
        return redirect()->back();
    }
}
