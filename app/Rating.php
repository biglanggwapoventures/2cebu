<?php

namespace App;

use App\Attraction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'attraction_id',
        'review',
        'rating',
        'rating_status',
    ];

    protected $casts = [
        'rating' => 'int',
    ];

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attraction()
    {
        return $this->belongsTo(Attraction::class, 'attraction_id');
    }

    public function is($status)
    {
        return strtolower($status) == $this->rating_status;
    }
}
