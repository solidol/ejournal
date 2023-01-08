<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $guarded = [];
    
    public $timestamps = false;
    protected $primaryKey = 'kod_subj';


    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'kod_pari');
    }
}
