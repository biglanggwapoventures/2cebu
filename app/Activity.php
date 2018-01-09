<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'attraction_id',
        'description',
        'cost',
        'remarks',
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
