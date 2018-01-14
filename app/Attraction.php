<?php

namespace App;

use App\Accomodation;
use App\Activity;
use App\AttractionCategory;
use App\Delicacy;
use App\Photo;
use App\Rating;
use App\Tag;
use App\Transportation;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'location',
        'latitude',
        'longitude',
        'festivities',
        'policy',
        'attraction_status',
        'status_remarks',
    ];

    public function accomodations()
    {
        return $this->hasMany(Accomodation::class);
    }

    public function delicacies()
    {
        return $this->hasMany(Delicacy::class);
    }

    public function transportations()
    {
        return $this->hasMany(Transportation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(AttractionCategory::class, 'attraction_category', 'attraction_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class)
            ->orderBy('id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(function ($owner) {
            $owner->firstname = 'N/A';
        });
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query->orderBy('id', 'desc')->with(['categories']);
    }

    public function thumbnail()
    {
        return $this->hasOne(Photo::class)
            ->orderBy('id');
    }

    public function placeDummyPhoto()
    {
        return $this->photos->push(new Photo);
    }

    public function is($status)
    {
        return strtolower($status) === $this->attraction_status;
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->whereUserId($userId);
    }

    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }

    public function isNotOwnedBy($userId)
    {
        return !$this->isOwnedBy($userId);
    }

    public function scopeApproved($query)
    {
        return $query->whereAttractionStatus('approved');
    }

    public function reviews()
    {
        return $this->hasMany(Rating::class, 'attraction_id');
    }

    public function approvedReviews()
    {
        return $this->reviews()->whereRatingStatus('approved');
    }
}
