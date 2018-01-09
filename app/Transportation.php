<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $fillable = [
        'attraction_id',
        'description',
        'start_point',
        'end_point',
        'fare',
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
