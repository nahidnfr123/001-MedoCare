<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyConversation extends Model
{
    use SoftDeletes;
    protected $fillable = ['sender_id', 'receiver_id', 'appointment_request_id', 'conversation_text', 'conversation_file', 'seen',];

    public function appointmentrequest(){
        return $this->belongsTo(AppointmentRequest::class, 'appointment_request_id', 'id');
    }
}
