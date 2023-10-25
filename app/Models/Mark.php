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
    protected $appends = ['id', 'type_control_title', 'mark_str', 'date_formatted', 'mark_national', 'mark_ects'];

    public function getIdAttribute()
    {
        return $this->kod_ocenki;
    }

    public function getMarkNationalAttribute()
    {
        if ($this->ocenka > 0) {
            if ($this->ocenka >= 0 && $this->ocenka < 30) {
                return 'Не задовільно';
            }
            if ($this->ocenka >= 30 && $this->ocenka < 60) {
                return 'Не задовільно';
            }
            if ($this->ocenka >= 60 && $this->ocenka < 64) {
                return 'Достатньо';
            }
            if ($this->ocenka >= 64 && $this->ocenka < 75) {
                return 'Задовільно';
            }
            if ($this->ocenka >= 75 && $this->ocenka < 82) {
                return 'Добре';
            }
            if ($this->ocenka >= 82 && $this->ocenka < 90) {
                return 'Дуже добре';
            }
            if ($this->ocenka >= 90 && $this->ocenka <= 100) {
                return 'Відмінно';
            }
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


    public function getMarkEctsAttribute()
    {
        if ($this->ocenka > 0) {
            if ($this->ocenka >= 0 && $this->ocenka < 30) {
                return 'F';
            }
            if ($this->ocenka >= 30 && $this->ocenka < 60) {
                return 'FX';
            }
            if ($this->ocenka >= 60 && $this->ocenka < 64) {
                return 'E';
            }
            if ($this->ocenka >= 64 && $this->ocenka < 75) {
                return 'D';
            }
            if ($this->ocenka >= 75 && $this->ocenka < 82) {
                return 'C';
            }
            if ($this->ocenka >= 82 && $this->ocenka < 90) {
                return 'B';
            }
            if ($this->ocenka >= 90 && $this->ocenka <= 100) {
                return 'A';
            }
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
                case null:
                    return null;
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

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'control_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function getDateFormattedAttribute()
    {
        return $this->data_->format('d.m.Y');
    }
}
