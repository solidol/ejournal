<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $timestamps = false;
    //public $fillable = ['from_id', 'to_id', 'message_type', 'content', 'created_at'];
    protected $guarded = [];
    protected $dates = ['datetime_start', 'datetime_end'];

    public function user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
