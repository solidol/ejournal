<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Log extends Model
{
    use HasFactory;
    //public $fillable = ['user_id', 'event', 'comment'];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createJournal($id)
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'create journal',
            'roles' => Auth::user()->roles,
            'ip_addr' => \Request::ip(),
            'comment' => "Користувач " . Auth::user()->userable->fullname . " створив журнал",
        ]);
    }


    public static function login()
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'roles' => Auth::user()->roles,
            'ip_addr' => \Request::ip(),
            'comment' => "Авторизація у веб-інтерфейс.\n Користувач " . Auth::user()->userable->fullname . " IP:" . \Request::ip(),
        ]);
    }

    public static function apiLogin()
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'roles' => Auth::user()->roles,
            'ip_addr' => \Request::ip(),
            'comment' => "Авторизація у API.\n Користувач " . Auth::user()->userable->fullname . " IP:" . \Request::ip(),
        ]);
    }

    public static function loginAs($id)
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'roles' => Auth::user()->roles,
            'ip_addr' => \Request::ip(),
            'comment' => 'Адміністратор ' . Auth::user()->userable->fullname . ' авторизується як користувач ' . User::find($id)->userable->fullname . "\n IP:" . \Request::ip(),
        ]);
    }

    public static function loginAs1($id)
    {
        Log::create([
            'user_id' => Auth::id(),
            'event' => 'login',
            'roles' => Auth::user()->roles,
            'ip_addr' => \Request::ip(),
            'comment' => 'Адміністратор ' . Auth::user()->userable->fullname . ' авторизується як користувач ' . User::find($id)->userable->fullname,
        ]);
    }
}
