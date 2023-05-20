<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class MDBController extends Controller
{


    public static function fileSizeHumanFriendly($fileSize)
    {
        if ($fileSize < 1024) {
            $ret_val = $fileSize . ' Байт';
        } elseif ($fileSize < 1048576) {
            $ret_val = round($fileSize / 1024, 1) . ' KБ';
        } elseif ($fileSize < 1073741824) {
            $ret_val = round($fileSize / 1048576, 1) . ' MБ';
        } else {
            $ret_val = round($fileSize / 1073741824, 1) . ' ГБ';
        }
        //
        return $ret_val;
    }

    public function index(Request $request)
    {
        $root = env('METHOD_DB');
        if ($request->dir) {
            $dir = $request->dir;
        } else {
            $dir = '';
        }
        $dir = str_replace(['..', $root], '', $dir);

        $breadcrumbs = [];
        $bc = explode('/', $dir);
        $breadCrumbsPath = '';
        foreach ($bc as $bcItem) {
            if ($bcItem) {
                $breadCrumbsPath .= '/' . $bcItem;
                $breadcrumbs[] = [
                    'title' => $bcItem,
                    'path' => $breadCrumbsPath
                ];
            }
        }

        $dirs =  Storage::disk('mdb')->directories($dir);

        foreach ($dirs as &$dirItem) {
            $dirItem = [
                'path' => str_replace($root, '', $dirItem),
                'title' => basename(str_replace($root, '', $dirItem)),
            ];
        }
        $files = Storage::disk('mdb')->files($dir);

        $arFiles = [];
        foreach ($files as $fileName) {
            $arFiles[] = [
                'fileName' => File::name(Storage::disk('mdb')->path($fileName)),
                'fileSize' => MDBController::fileSizeHumanFriendly(Storage::disk('mdb')->size($fileName)),
                'url' => route('get_method_download') . '?file=' . $fileName,
            ];
        }

        return view('teacher.mdb_list', [
            'files' => $arFiles,
            'dirs' => $dirs,
            'dir' => $dir,
            'breadcrumbs' => $breadcrumbs,
            'retPath' => str_replace('.', '', dirname($dir)),
        ]);
    }

    public function download(Request $request)
    {
        if ($request->file) {

            return Storage::disk('mdb')->download($request->file);
        }
    }
}
