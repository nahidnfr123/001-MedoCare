<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'doctor_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'week_days',
        'fees',
        'booking_start_date',
        'booking_status',
        'validity',
        'created_at',
    ];

    public function getStartDateAttribute($value){ // Set default start date format ...
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function getEndDateAttribute($value){ // Set default end date format ...
        return Carbon::parse($value)->format('d-m-Y');
    }
    /*public function getStartTimeAttribute($value){ // Set default start time format ...
        return Carbon::parse($value)->format('h:i a');
    }
    public function getEndTimeAttribute($value){ // Set default end time format ...
        return Carbon::parse($value)->format('h:i a');
    }*/



    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function appointmentbooking(){
        return $this->hasMany(AppointmentBooking::class, 'appointment_id', 'id');
    }
}
