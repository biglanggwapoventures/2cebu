<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class AttractionCategory extends Model
{
    protected $fillable = [
        'description',
    ];

    public function scopeFieldsForMasterList($query)
    {
        return $query->orderBy('description');
    }

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class, 'attraction_category', 'category_id', 'attraction_id');
    }

    public function scopeDropdownFormat()
    {
        return $this->get()->pluck('description', 'id')->prepend('** ALL CATEGORIES ** ', '');
    }
}
