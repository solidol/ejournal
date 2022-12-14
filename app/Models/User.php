<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userable()
    {
        return $this->morphTo();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function hasRole($role = false)
    {
        if (!$role) return false;
        $roles = explode(',', $this->roles);
        if (in_array($role, $roles)) return true;
        else return false;
    }

    public function getMySubjects()
    {
        $lessons = Lesson::select('kod_grupi', 'kod_subj', 'kod_prep')->
        where('kod_prep', $this->userable_id)->distinct()->get();
        foreach ($lessons as &$lesson){
            $lesson->hrsum = Lesson::
            where('kod_prep',Auth::user()->userable_id)->
            where('kod_subj',$lesson->kod_subj)->
            where('kod_grupi',$lesson->kod_grupi)->
            sum('kol_chasov');
        }
        return $lessons;
    }

    function getStudents($group)
    {
        return Students::where('kod_grup', $group)->orderBy('FIO_stud')->get();
    }
}
