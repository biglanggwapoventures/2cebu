<?php

namespace App;

use App\Attraction;
use App\User;
use Carbon\Carbon;
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
        return $query->whereRatingStatus('approved');
    }

    public function is($status)
    {
        return strtolower($status) == $this->rating_status;
    }

    public function scopeGivenBy($query, $userId)
    {
        return $query->whereUserId($userId);
    }

    public function isWeekOld()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'Asia/Manila')
            ->diffInDays(Carbon::now('Asia/Manila')) >= 7;
    }
}
