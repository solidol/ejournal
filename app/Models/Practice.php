<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class Practice extends Model
{
    use HasFactory;
    protected $table = 'controls';
    public $timestamps = false;
    protected $guarded = [];
    protected $appendds = ['type_title'];
    protected $dates = ['date_', 'date_formatted', 'max_grade_str'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('practice', function (Builder $builder) {
            $builder->where('type_', 11)->orWhere('type_', 12)->orWhere('type_', 13);
        });
    }
    public function getMaxGradeStrAttribute(){
        if ($this->max_grade > 0) {    
            return (string) $this->max_grade;
        } else {
            switch ($this->max_grade) {
                case -1:
                    return "Н/А";
                    break;
                case -2:
                    return "Зар";
                    break;
                case null:
                    return null;
                    break;
                default:
                    return '';
                    break;
            }
        }
    }
    public function getTypeTitleAttribute()
    {
        switch ($this->type_) {
            case 11:
                return "Лабораторна робота";
                break;
            case 12:
                return "Практична робота";
                break;
            case 13:
                return "Лабораторні підсумок";
                break;
            case 14:
                return "Практичні підсумок";
                break;
            default:
                return "-";
                break;
        }
    }
    public function getDateFormattedAttribute()
    {
        return $this->date_ ? $this->date_->format('d.m.Y') : 'Відсутня дата';
    }
    public function marks()
    {
        return $this->hasMany(Mark::class, 'control_id')->where('kod_stud', '>', 0)->orderBy('data_');
    }
    public function marksHeader()
    {
        return $this->hasMany(Mark::class, 'control_id')->where('kod_stud', 0);
    }
    public function mark($student_id)
    {
        return $this->marks->where('kod_stud', $student_id)->first() ?? false;
    }
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id','kod_pari');
    }
    public function additionals()
    {
        return $this->morphMany(Additional::class, 'additionable');
    }
    
}
