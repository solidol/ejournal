<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $guarded = [];
    protected $appends = ['title'];
    
    public $timestamps = false;
    protected $primaryKey = 'kod_subj';

    public function getTitleAttribute(){
        return $this->subject_name;
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'kod_pari');
    }
}
