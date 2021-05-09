<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'seen', 'created_at', 'replied',
    ];
}
