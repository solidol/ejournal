<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'spisok_stud';

    public $timestamps = false;
    protected $primaryKey = 'kod_stud';
    
    public function group()
    {
        return $this->belongsTo(Group::class, 'kod_grup');
    }
}
