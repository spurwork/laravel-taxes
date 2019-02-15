<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';

    protected $fillable = ['name', 'class'];

    protected $guarded = [];

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        $this->table = config('taxes.tables.taxes');
    }

    public function taxAreas()
    {
        return $this->hasMany(TaxArea::class);
    }

    public function scopeAtPoint($query, $home_location, $work_location)
    {
        return $query->whereHas('taxAreas', function ($query) use ($home_location, $work_location) {
            $query->atPoint($home_location, $work_location);
        });
    }
}
