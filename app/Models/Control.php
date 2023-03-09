<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Control extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $appendds = ['type_title'];
    protected $dates = ['date_', 'date_formatted'];
    public function getTypeTitleAttribute()
    {
        switch ($this->type_) {
            case 0:
                return "Поточний";
                break;
            case 1:
                return "Модульний";
                break;
            case 2:
                return "Підсумковий";
                break;
            default:
                return "-";
                break;
        }
    }
    public function getDateFormattedAttribute()
    {
        return $this->date_?$this->date_->format('d.m.Y'):'00.00.0000';
    }
    public function marks()
    {
        return $this->hasMany(Mark::class, 'control_id')->where('kod_stud', '>', 0);
    }

    public function mark($student_id)
    {
        return $this->marks->where('kod_stud', $student_id)->first() ?? ((object) array('mark_str' => '', 'ocenka' => '0'));
    }
}
