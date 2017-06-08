<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class TaxArea extends Model
{
    protected $table = 'tax_areas';

    protected $guarded = [];

    public function governmentalUnitArea()
    {
        return $this->belongsTo(GovernmentalUnitArea::class);
    }

    public function getTaxAttribute($value)
    {
        return app($value);
    }

    public function scopeAtPoint($query, $latitude, $longitude)
    {
        return $query->whereHas('governmentalUnitArea', function ($query) use ($latitude, $longitude) {
            $query->atPoint($latitude, $longitude);
        });
    }
}
