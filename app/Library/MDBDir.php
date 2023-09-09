<?php

namespace App\Library;

use Illuminate\Support\Facades\Storage;
use App\Library\MDBBreadcrumbs;
use stdClass;

class MDBDir
{
    public $root;
    public $dir;
    public $dirs;
    public $files;
    public $breadcrumbs;
    public $pathto;

    function __construct($dir, $root)
    {
        $this->root = $root;
        $this->pathto = str_replace('.', '', dirname($dir));
        $this->dir = str_replace(['/..', '../', '..', $this->root], '', $dir);

        $this->addDirs();

        $this->addFiles();

        $this->addBreadcrumbs();
    }


    private function addFiles()
    {
        $files = Storage::disk('mdb')->files($this->dir);
        asort($files);

        $arFiles = [];
        foreach ($files as $filename) {
            $arFiles[] = new MDBFile($filename, true);
        }
        $this->files = $arFiles;
        return $this->files;
    }
    private function addDirs()
    {
        $dirs = Storage::disk('mdb')->directories($this->dir);
        asort($dirs);
        $pattern = '/^\./';
        $dirs = array_filter($dirs, function ($item) use ($pattern) {
            return !preg_match($pattern, $item);
        });
        foreach ($dirs as &$dirItem) {
            $dirItem = (object)[
                'path' => str_replace($this->root, '', $dirItem),
                'title' => basename(str_replace($this->root, '', $dirItem)),
            ];
        }

        $this->dirs = $dirs;
    }

    private function addBreadcrumbs()
    {
        $this->breadcrumbs = [];
        $bc = explode('/', $this->dir);
        $breadсrumbsPath = '';
        foreach ($bc as $bcItem) {
            if ($bcItem) {
                $breadсrumbsPath .= '/' . $bcItem;
                $this->breadcrumbs[] = (object) [
                    'title' => $bcItem,
                    'path' => $breadсrumbsPath
                ];
            }
        }
        return $this->breadcrumbs;
    }
}
