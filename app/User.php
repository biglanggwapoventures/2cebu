<?php

namespace App;

use App\Attraction;
use App\Rating;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_uid',
        'google_uid',
        'email',
        'username',
        'password',
        'firstname',
        'lastname',
        'gender',
        'contact_number',
        'address',
        'display_photo',
    ];

    protected $appends = [
        'fullname',
        'registration_method',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = Hash::make($val);
    }

    public function getRegistrationMethodAttribute()
    {
        if (is_null($this->facebook_uid) && is_null($this->google_uid)) {
            return 'ON SITE';
        }

        return is_null($this->facebook_uid) ? 'Google' : 'Facebook';
    }

    public function likedAttractions()
    {
        return $this->belongsToMany(Attraction::class, 'attraction_like', 'user_id', 'attraction_id')->select('attractions.id');
    }

    public function reviews()
    {
        return $this->hasMany(Rating::class);
    }
}
