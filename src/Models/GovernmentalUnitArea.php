<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class GovernmentalUnitArea extends Model
{

    protected $table = 'governmental_unit_areas';

    protected $guarded = [];

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        $this->table = config('taxes.tables.governmental_unit_areas');
    }

    public function homeTaxAreas()
    {
        return $this->hasMany(TaxArea::class, 'home_governmental_unit_area_id');
    }

    public function workTaxAreas()
    {
        return $this->hasMany(TaxArea::class, 'work_governmental_unit_area_id');
    }

    public function scopeAtPoint($query, $latitude, $longitude)
    {
        return $query->whereRaw('ST_Contains('.config('taxes.tables.governmental_unit_areas').'.area, ST_SetSRID(ST_MakePoint(?, ?), 4326))', [$longitude, $latitude]);
    }
}
