<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogView extends Model
{
    //
    protected $fillable = [
        'ip_address', 'blog_id', 'user_id',
    ];

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
