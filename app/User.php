<?php

namespace App;

use http\Exception\UnexpectedValueException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'dob', 'phone', 'gender', 'avatar', 'blood_group','location','address', 'blocked', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'blocked', 'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date:Y-m-d',
    ];

    public function userIsOnline(){
        return Cache::has('user-is-online-' . $this->id);
    }

    public function doctorIsOnline(){
        return Cache::has('doctor-is-online-'.$this->id);
    }

    // .... Pivot table relation ship .... //
    public function role(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function patient(){
        return $this->hasOne(Patient::class);
    }

    public function doctor(){
        return $this->hasOne(Doctor::class);
    }

    public function scopeVerified_active($query){
        return $query->where('email_verified_at','!=', null)->where('blocked', '!=', 1);
    }

    public function consultation(){
        return $this->hasMany(Consultation::class);
    }

}
