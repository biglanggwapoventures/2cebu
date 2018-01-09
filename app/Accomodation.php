<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    protected $fillable = [
        'attraction_id',
        'description',
        'remarks',
        'min_rate',
        'max_rate',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }
}
