<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Library\MDBFile;
use App\Library\MDBDir;

class MDBController extends Controller
{



    public function index(Request $request)
    {
        $root = env('METHOD_DB');
        if ($request->dir) {
            $dir = $request->dir;
        } else {
            $dir = '';
        }

        $obDir = new MDBDir($dir, $root);

        
        return view('mdb.index', [
            'dir' => $obDir,
        ]);
    }

    public function download(Request $request)
    {
        if ($request->file) {

            return Storage::disk('mdb')->download($request->file);
        }
    }
}
