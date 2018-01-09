<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'attraction_id',
        'caption',
        'filename',
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
