<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'deleted_at'];

    //\\ .... Pivot table relation ship .... //\\
    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
