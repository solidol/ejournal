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



    public function isAdmin()
    {
        if ($this->usertype == 'admin') return true;
        else return false;
    }
/* old
    public static function getMySubjects()
    {
        return DB::table('subjects')->
        join('lessons_', 'subjects.kod_subj', '=', 'lessons_.kod_subj')->
        join('grups', 'lessons_.kod_grupi', '=', 'grups.kod_grup')->
        where('lessons_.kod_prep', Auth::user()->usercode)->
        select('nomer_grup', 'kod_grup', 'subjects.kod_subj', 'subject_name')->
        orderBy('nomer_grup')->orderBy('subject_name')->distinct()->get();
    }
*/
    public function getMySubjects()
    {
        return $lessons = Lesson::select('kod_grupi', 'kod_subj', 'kod_prep')->
        where('kod_prep', $this->usercode)->distinct()->get();
    }

    function getStudents($group)
    {
        return DB::table('spisok_stud')->where('kod_grup', $group)->orderBy('FIO_stud')->get();
    }
}
