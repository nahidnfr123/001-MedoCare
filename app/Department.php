<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use SoftDeletes;
    protected $fillable = ['department_name', 'icon', 'details', 'deleted_at'];

    public function doctor(){
        return $this->hasMany(Doctor::class, 'department_id', 'id');
    }
}
