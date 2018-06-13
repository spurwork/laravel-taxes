<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class TaxArea extends Model
{
    const BASED_ON_HOME_LOCATION = 'home';
    const BASED_ON_WORK_LOCATION = 'work';

    protected $table = 'tax_areas';

    protected $guarded = [];

    public $timestamps = false;

    public function __construct() {
        parent::__construct();
        $this->table = config('taxes.tables.tax_areas');
    }

    public function governmentalUnitArea()
    {
        return $this->belongsTo(GovernmentalUnitArea::class);
    }

    public function scopeAtPoint($query, $latitude, $longitude)
    {
        return $query->whereHas('governmentalUnitArea', function ($query) use ($latitude, $longitude) {
            $query->atPoint($latitude, $longitude);
        });
    }

    public function scopeBasedOnHomeLocation($query)
    {
        return $query->where('based', TaxArea::BASED_ON_HOME_LOCATION);
    }

    public function scopeBasedOnWorkLocation($query)
    {
        return $query->where('based', TaxArea::BASED_ON_WORK_LOCATION);
    }
}
