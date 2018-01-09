<?php

namespace App;

use App\Attraction;
use App\Helpers\MyHelper;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'attraction_id',
        'caption',
        'filename',
    ];

    protected $appends = [
        'filepath',
    ];

    public function getFilepathAttribute()
    {
        return $this->filename ? asset("storage/{$this->filename}") : MyHelper::photoPlaceholder();
    }

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query;
    }
}
