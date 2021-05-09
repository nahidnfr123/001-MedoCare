<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/*use Torann\GeoIP\Cache;*/

class Doctor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'work_place_name',
        'work_place_document',
        'experience',
        'education',
        'nationality',
        'working_days',
        'about',
        'fees',
        'department_id',
        'user_id',
    ];

    public function doctorIsOnline(){
        return Cache::has('doctor-is-online-'.$this->id);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function availableUser(){
        return $this->user()->where('email_verified_at','!=', null)->where('blocked', '!=', 1);
    }


    public function doctorrating(){
        return $this->hasMany(DoctorRating::class, 'doctor_id', 'id');
    }

    public function appointment(){
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    public function consultation(){
        return $this->hasMany(Consultation::class, 'doctor_id', 'id');
    }
}
