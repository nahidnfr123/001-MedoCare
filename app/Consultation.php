<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    //

    use SoftDeletes;
    protected $fillable = ['user_id', 'doctor_id', 'appointment_booking_id', 'status'];

    public function appointmentbooking(){
        return $this->belongsTo(AppointmentBooking::class, 'appointment_booking_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function conversation(){
        return $this->hasMany(Conversation::class);
    }
    public function report(){
        return $this->hasMany(PatientReport::class);
    }
}
