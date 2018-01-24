<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
        'region',
    ];

    public function getRegionAttribute($value)
    {
        return $value ?: 'city';
    }

    public function scopeDropdownFormat()
    {
        return $this->get()
            ->groupBy('region')
            ->mapWithKeys(function ($item, $key) {
                return [ucfirst($key) => $item->pluck('name', 'name')->toArray()];
            })
            ->prepend('** ALL MUNICIPALITIES ** ', '');
    }
}
