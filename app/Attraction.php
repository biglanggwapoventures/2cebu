<?php

namespace App;

use App\Accomodation;
use App\Activity;
use App\AttractionCategory;
use App\Delicacy;
use App\Photo;
use App\Rating;
use App\Tag;
use App\Transportation;
use App\User;
use DB;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'location',
        'latitude',
        'longitude',
        'festivities',
        'budget_range_min',
        'budget_range_max',
        'policy',
        'attraction_status',
        'status_remarks',
        'is_featured',
        'feature_banner',
    ];

    protected $appends = [
        'average_rating',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
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

    public function photos()
    {
        return $this->hasMany(Photo::class)
            ->orderBy('id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(function ($owner) {
            $owner->firstname = 'N/A';
        });
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query->orderBy('id', 'desc')->with(['categories']);
    }

    public function thumbnail()
    {
        return $this->hasOne(Photo::class)
            ->orderBy('id');
    }

    public function placeDummyPhoto()
    {
        return $this->photos->push(new Photo);
    }

    public function is($status)
    {
        return strtolower($status) === $this->attraction_status;
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->whereUserId($userId);
    }

    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }

    public function isNotOwnedBy($userId)
    {
        return !$this->isOwnedBy($userId);
    }

    public function scopeApproved($query)
    {
        return $query->whereAttractionStatus('approved');
    }

    public function scopeLikedBy($query, $userId)
    {
        return $query->whereHas('likers', function ($q) use ($userId) {
            return $q->whereUserId($userId);
        });
    }

    public function reviews()
    {
        return $this->hasMany(Rating::class, 'attraction_id');
    }

    public function approvedReviews()
    {
        return $this->reviews()->whereRatingStatus('approved');
    }

    public function pendingReviews()
    {
        return $this->reviews()->whereRatingStatus('pending');
    }

    public function getAverageRatingAttribute()
    {
        return $this->relationLoaded('approvedReviews') ? $this->approvedReviews->avg('rating') : 0;
    }

    public function likers()
    {
        return $this->belongsToMany(User::class, 'attraction_like', 'attraction_id', 'user_id');
    }

    public function isLikedBy($userId)
    {
        return $this->relationLoaded('likers')
        ? $this->likers->where('id', $userId)->first()
        : $this->likers()->where('users.id', $userId)->exists();
    }

    public static function scopeTop($query, $limit = 6)
    {
        $result = self::queryTop($limit);
        // dd($result->toArray());

        if ($result->isEmpty()) {
            return $query;
        }

        return $query->whereIn('id', $result->pluck('id'));
    }

    public function scopeNewest($query, $limit = 6)
    {
        return $query->approved()
            ->orderBy('id', 'desc')
            ->limit(6);
    }

    public static function queryTop($limit = 6)
    {
        $self = new static;

        return DB::table($self->getTable())
            ->select('attractions.id', DB::raw('IFNULL(AVG(ratings.rating), 0) AS average_rating'))
            ->whereAttractionStatus('approved')
            ->leftJoin('ratings', function ($join) {
                $join->on('ratings.attraction_id', '=', 'attractions.id')
                    ->whereRatingStatus('approved');
            })
            ->groupBy('attractions.id')
            ->orderBy('average_rating', 'desc')
            ->limit($limit)
            ->get();
    }

    public function scopeFeatured($query)
    {
        return $query->whereIsFeatured(1);
    }

    public function getFeatureBannerAttribute($value)
    {
        return $value ? asset("storage/{$value}") : null;
    }

    public function scopeForShowcase($query)
    {
        return $query->with([
            'photos',
            'categories',
            'tags',
            'approvedReviews',
            'likers',
        ]);
    }

    public function scopeWithTerm($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%");
        })->orWhereHas('tags', function ($q) use ($term) {
            $q->where('description', 'like', "%{$term}%");
        });
    }

    public function scopeFeaturedFirst($query)
    {
        return $query->orderBy('is_featured', 'desc');
    }

    public function scopeNameLike($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%");
    }

    public function scopeLocationLike($query, $value)
    {
        return $query->where('location', 'like', "%{$value}%");
    }

    public function scopeOfStatus($query, $value)
    {
        return $query->whereAttractionStatus($value);
    }

    public function scopeWithCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('attraction_categories.id', '=', $categoryId);
        });
    }

    public function scopeWithPendingReviewsCount($query)
    {
        return $query->approved()->whereHas('pendingReviews')->withCount('pendingReviews');
    }
}
