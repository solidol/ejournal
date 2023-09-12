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


    protected $appends = ['id', 'fullname', 'shortname', 'shortname_rev'];

    public function getIdAttribute()
    {
        return $this->kod_stud;
    }
    public function getFullnameAttribute()
    {
        return $this->FIO_stud;
    }
    public function getShortnameAttribute()
    {
        $name = explode(' ', $this->FIO_stud);
        if (is_array($name))
            $shortname = $name[0] . " " . mb_substr($name[1]??' ', 0, 1) . "." . mb_substr($name[2]??' ', 0, 1) . ".";
        else
            $shortname = $name;
        return $shortname;
    }
    public function getShortnameRevAttribute()
    {
        $name = explode(' ', $this->FIO_stud);
        if (is_array($name))
            $shortname = mb_substr($name[1]??' ', 0, 1) . "." . mb_substr($name[2]??' ', 0, 1) . ". " . $name[0];
        else
            $shortname = $name;
        return $shortname;
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
    public function lastLogin()
    {
        if ($this->user && $this->user->logins) {
            return $this->user->logins->last();
        } else {
            return false;
        }
    }
}
