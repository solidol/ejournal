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
        $dir = str_replace(['/..', '../', $root], '', $dir);

        $breadcrumbs = [];
        $bc = explode('/', $dir);
        $breadсrumbsPath = '';
        foreach ($bc as $bcItem) {
            if ($bcItem) {
                $breadсrumbsPath .= '/' . $bcItem;
                $breadcrumbs[] = [
                    'title' => $bcItem,
                    'path' => $breadсrumbsPath
                ];
            }
        }

        $dirs = Storage::disk('mdb')->directories($dir);
        asort($dirs);
        $pattern = '/^\./';
        $dirs = array_filter($dirs, function ($item) use ($pattern) {
            return !preg_match($pattern, $item);
        });
        foreach ($dirs as &$dirItem) {
            $dirItem = [
                'path' => str_replace($root, '', $dirItem),
                'title' => basename(str_replace($root, '', $dirItem)),
            ];
        }


        $files = Storage::disk('mdb')->files($dir);
        asort($files);

        $arFiles = [];
        foreach ($files as $fileName) {
            $pathInfo = pathinfo(Storage::disk('mdb')->path($fileName));
            if (isset($pathInfo['extension'])) {
                switch ($pathInfo['extension']) {
                    case 'rar':
                    case 'zip':
                        $icon = '_zip.png';
                        break;
                    case 'txt':
                        $icon = '_txt.png';
                        break;
                    case 'pdf':
                        $icon = '_pdf.png';
                        break;
                    case 'png':
                    case 'jpeg':
                    case 'jpg':
                    case 'gif':
                        $icon = '_image.png';
                        break;
                    case 'docx':
                    case 'doc':
                        $icon = '_word.png';
                        break;
                    case 'xlsx':
                    case 'xls':
                        $icon = '_excel.png';
                        break;
                    case 'pptx':
                    case 'ppt':
                        $icon = '_powerpoint.png';
                        break;
                    default:
                        $icon = '_file.png';
                        break;
                }
            } else {
                $icon = '_file.png';
            }

            $arFiles[] = [
                'fileName' => $pathInfo['basename'],
                'fileSize' => MDBController::fileSizeHumanFriendly(Storage::disk('mdb')->size($fileName)),
                'url' => route('get_method_download') . '?file=' . $fileName,
                'icon' => $icon,
            ];
        }

        return view('teacher.mdb_list', [
            'files' => $arFiles,
            'dirs' => $dirs,
            'dir' => $dir,
            'breadcrumbs' => $breadcrumbs,
            'retPath' => str_replace('/.', '', dirname($dir)),
        ]);
    }

    public function download(Request $request)
    {
        if ($request->file) {

            return Storage::disk('mdb')->download($request->file);
        }
    }
}
