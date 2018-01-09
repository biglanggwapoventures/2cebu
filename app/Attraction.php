<?php

namespace App;

use App\Accomodation;
use App\Activity;
use App\AttractionCategory;
use App\Delicacy;
use App\Tag;
use App\Transportation;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'latitude',
        'longitude',
        'festivities',
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

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }
}
