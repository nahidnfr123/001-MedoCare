<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentBooking extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['user_id', 'appointment_id', 'booked_date', 'booked_time', 'token'];

    public function getBookedDateAttribute($value){ // Set default end date format ...
        return Carbon::parse($value)->format('d-m-Y');
    }
    /*public function getBookedTimeAttribute($value){ // Set default start time format ...
        return Carbon::parse($value)->format('H:i a');
    }*/

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function consultation(){
        return $this->hasOne(Consultation::class);
    }
}
