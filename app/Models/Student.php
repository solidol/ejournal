<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'spisok_stud';
    protected $guarded = [];

    public $timestamps = false;
    protected $primaryKey = 'kod_stud';
    protected $appends = ['id','fullname'];

    public function getIdAttribute()
    {
        return $this->kod_stud;
    }
    public function getFullnameAttribute()
    {
        return $this->FIO_stud;
    }
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'kod_grup', 'kod_grup');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'kod_stud');
    }

    public function absents()
    {
        return $this->hasMany(Absent::class, 'kod_stud');
    }

}
