<?php

namespace App;

use App\Attraction;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'description',
    ];

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }
}
