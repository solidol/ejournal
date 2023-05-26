<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiplomaProjecting extends Model
{
    use HasFactory;

    protected $dates = ['com_date'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'kod_grup')->orderBy('nomer_grup');
    }
    public function scriber()
    {
        return $this->belongsTo(Teacher::class, 'scriber_id', 'kod_prep');
    }
}
