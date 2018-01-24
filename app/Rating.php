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
        return $this->belongsTo(User::class, 'user_id')->withDefault(function ($user) {
            $user->firstname = '[deleted]';
        });
    }

    public function attraction()
    {
        return $this->belongsTo(Attraction::class, 'attraction_id');
    }

    public function scopeApproved($query)
    {
        return $this->whereRatingStatus('approved');
    }

    public function is($status)
    {
        return strtolower($status) == $this->rating_status;
    }

    public function scopeGivenBy($query, $userId)
    {
        return $this->whereUserId($userId);
    }
}
