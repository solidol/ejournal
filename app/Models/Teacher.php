<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'prepod';
    protected $primaryKey = 'kod_prep';
    protected $guarded = [];
    
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(App\Models\User::class, 'userable');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'teacher_id');
    }
}
