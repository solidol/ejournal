<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Control extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $appendds = [];
    public function marks()
    {
        return $this->hasMany(Mark::class, 'control_id')->where('kod_stud', '>', 0);
    }

    public function onlyMarks()
    {
        return $this->marks()->where('kod_stud', '>', 0)->get();
    }

    public function mark($student_id)
    {
        return $this->marks->where('kod_stud', $student_id)->first() ?? ((object) array('mark_str' => '-', 'ocenka' => '0'));
    }
}
