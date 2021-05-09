<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'image', 'description', 'author', 'publish_date', 'deleted_at',
    ];

    public function comment(){
        return $this->hasMany(BlogComment::class);
    }

    public function view(){
        return $this->hasMany(BlogView::class);
    }





    // for view counting relation ...
    public function commentsCountRelation(){
        return $this->hasOne(BlogView::class)->selectRaw('blog_id, count(*) as count')
            ->groupBy('blog_id');
    }
    public function getCommentsCountAttribute(){
        return $this->commentsCountRelation ?
            $this->commentsCountRelation->count : 0;
    }
    // End view counting ...
}
