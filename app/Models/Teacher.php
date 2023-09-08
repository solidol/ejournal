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
    protected $appends = ['id', 'fullname','shortname','shortname_rev'];

    public function getFullnameAttribute()
    {
        return $this->FIO_prep;
    }
    public function getIdAttribute()
    {
        return $this->kod_prep;
    }
    public function getShortnameAttribute()
    {
        $name = explode(' ',$this->FIO_prep);
        $shortname = $name[0]." ".mb_substr($name[1], 0, 1).".".mb_substr($name[2], 0, 1).".";
        return $shortname;
    }
    public function getShortnameRevAttribute()
    {
        $name = explode(' ',$this->FIO_prep);
        $shortname = mb_substr($name[1], 0, 1).".".mb_substr($name[2], 0, 1).". ".$name[0];
        return $shortname;
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
    public function curLocalStudents()
    {
        return $this->hasManyThrough(
            Student::class, 
            Group::class,
            'kod_prep', // Внешний ключ в таблице `groups` ...
            'kod_grup', // Внешний ключ в таблице `students` ...
            'kod_prep', // Локальный ключ в таблице `teachers` ...
            'kod_grup' // Локальный ключ в таблице `groups` ...
        );
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class, 
            Journal::class,
            'teacher_id', // Внешний ключ в таблице `environments` ...
            'journal_id', // Внешний ключ в таблице `deployments` ...
            'id', // Локальный ключ в таблице `projects` ...
            'id' // Локальный ключ в таблице `environments` ...
        );
    }
}
