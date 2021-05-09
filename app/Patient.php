<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function doctorrating(){
        return $this->hasMany(DoctorRating::class, 'patient_id', 'id');
    }

    public function appointmentBooking(){
        return $this->hasMany(AppointmentBooking::class, 'patient_id', 'id');
    }
}
