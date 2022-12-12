<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'grups';

    public $timestamps = false;
    protected $primaryKey = 'kod_grup';

    public function students()
    {
        return $this->hasMany(Student::class, 'kod_grup', 'kod_stud');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'kod_grupi', 'kod_grup');
    }
}
