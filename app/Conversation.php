<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;
    protected $fillable = ['sender_id', 'receiver_id', 'consultation_id', 'conversation_text', 'conversation_file', 'seen',];

    public function consultation(){
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }
}
