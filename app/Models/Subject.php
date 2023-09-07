<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $guarded = [];
    protected $appends = ['title', 'short_title'];

    public $timestamps = false;
    protected $primaryKey = 'kod_subj';

    public function getTitleAttribute()
    {
        return $this->subject_name;
    }

    public function getShortTitleAttribute()
    {
        $ar = explode(" ", $this->subject_name);
        $st = "";
        foreach ($ar as $item) {
            $st .= mb_substr($item, 0, 1);
        }
        return mb_strtoupper($st);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'kod_pari');
    }
}
