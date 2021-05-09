<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    //

    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
}
