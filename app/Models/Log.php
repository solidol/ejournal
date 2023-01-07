<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Log extends Model
{
    use HasFactory;
    public $fillable = ['user_id', 'event', 'comment'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function login()
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'comment' => "Авторизація у веб-інтерфейс.\n Користувач " . Auth::user()->name . " IP:" . \Request::ip(),
        ]);
    }

    public static function loginAs($id)
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'comment' => 'Адміністратор ' . Auth::user()->name . ' авторизується як користувач ' . User::find($id)->name . "\n IP:" . \Request::ip(),
        ]);
    }

    public static function loginAs1($id)
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'comment' => 'Адміністратор ' . Auth::user()->name . ' авторизується як користувач ' . User::find($id)->name,
        ]);
    }
}
