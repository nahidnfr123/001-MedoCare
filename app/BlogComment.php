<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id', 'comment', 'blog_id', 'user_id', 'deleted_at'
    ];

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }
}
