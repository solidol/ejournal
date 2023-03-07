<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;




class Mark extends Model
{
    //
    protected $table = 'ocenki';
    protected $primaryKey = 'kod_ocenki';
    protected $guarded = [];
    protected $dates = ['data_'];
    public $timestamps = false;
    protected $appends = ['type_control_title', 'mark_str'];

    public function getMarkStrAttribute()
    {
        if ($this->ocenka > 0) {
            return $this->ocenka;
        } else {
            switch ($this->ocenka) {
                case -1:
                    return "Н/А";
                    break;
                case -2:
                    return "Зар";
                    break;
                default:
                    return '';
                    break;
            }
        }
    }

    public function getTypeControlTytleAttribute()
    {
        switch ($this->type_kontrol) {
            case 0:
                return "Поточний";
                break;
            case 1:
                return "Модульний";
                break;
            case 2:
                return "Підсумковий";
                break;
            default:
                return "-";
                break;
        }
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'kod_stud');
    }

    public function control()
    {
        return $this->belongsTo(Control::class, 'control_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }


  
}
