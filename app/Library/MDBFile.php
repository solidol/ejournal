<?php

namespace App\Library;

use Illuminate\Support\Facades\Storage;

class MDBFile
{
    public $isfile = false;
    public $pathInfo;
    public $basename;
    public $filename;
    public $filesizeStr;
    public $url;
    public $icon = '_file.png';

    function __construct($ffn, $isfile = false)
    {
        if ($isfile) {
            $this->pathInfo = pathinfo(Storage::disk('mdb')->path($ffn));
            $this->setIcon();
            $this->basename = $this->pathInfo['basename'];
            $this->filename = $ffn;
            $this->url = route('mdb.download') . '?file=' . $this->filename;
            $this->filesizeStr = static::filesizeHumanFriendly(Storage::disk('mdb')->size($ffn));
        }
    }

    public function setIcon()
    {
        if (isset($this->pathInfo['extension'])) {
            switch ($this->pathInfo['extension']) {
                case 'rar':
                case 'zip':
                    $this->icon = '_zip.png';
                    break;
                case 'txt':
                    $this->icon = '_txt.png';
                    break;
                case 'pdf':
                    $this->icon = '_pdf.png';
                    break;
                case 'png':
                case 'jpeg':
                case 'jpg':
                case 'gif':
                    $this->icon = '_image.png';
                    break;
                case 'docx':
                case 'doc':
                    $this->icon = '_word.png';
                    break;
                case 'xlsx':
                case 'xls':
                    $this->icon = '_excel.png';
                    break;
                case 'pptx':
                case 'ppt':
                    $this->icon = '_powerpoint.png';
                    break;
                default:
                    $this->icon = '_file.png';
                    break;
            }
        } else {
            $this->icon = '_file.png';
        }
    }

    public static function filesizeHumanFriendly($filesize)
    {
        if ($filesize < 1024) {
            $fszStr = $filesize . ' Байт';
        } elseif ($filesize < 1048576) {
            $fszStr = round($filesize / 1024, 1) . ' KБ';
        } elseif ($filesize < 1073741824) {
            $fszStr = round($filesize / 1048576, 1) . ' MБ';
        } else {
            $fszStr = round($filesize / 1073741824, 1) . ' ГБ';
        }
        return $fszStr;
    }
}
