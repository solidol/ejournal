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
    protected $appends = ['id', 'fullname'];

    public function getFullnameAttribute()
    {
        return $this->FIO_prep;
    }
    public function getIdAttribute()
    {
        return $this->kod_prep;
    }
    public function user()
    {
        return $this->morphOne(App\Models\User::class, 'userable');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'teacher_id');
    }
    public function journalsByGroup($group_id)
    {
        return $this->journals->where('group_id', $group_id);
    }
    public function groups()
    {
        return $this->hasMany(Group::class, 'kod_prep');
    }
}
