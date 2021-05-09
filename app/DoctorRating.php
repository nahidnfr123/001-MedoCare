<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorRating extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'rating_value',
        'title',
        'comments',
        'created_at',
        'created_at',
    ];
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
