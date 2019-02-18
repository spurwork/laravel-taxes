<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class TaxArea extends Model
{
    const BASED_ON_HOME_LOCATION = 'home';
    const BASED_ON_WORK_LOCATION = 'work';
    const BASED_ON_HOME_AND_NOT_WORK_LOCATION = 'home_not_work';
    const BASED_ON_WORK_AND_NOT_HOME_LOCATION = 'work_not_home';
    const BASED_ON_BOTH_LOCATIONS = 'both';
    const BASED_ON_EITHER_LOCATION = 'either';

    protected $table = 'tax_areas';

    protected $guarded = [];

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        $this->table = config('taxes.tables.tax_areas');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function homeGovernmentalUnitArea()
    {
        return $this->belongsTo(GovernmentalUnitArea::class, 'home_governmental_unit_area_id');
    }

    public function workGovernmentalUnitArea()
    {
        return $this->belongsTo(GovernmentalUnitArea::class, 'work_governmental_unit_area_id');
    }

    public function scopeAtPoint($query, $home_location, $work_location)
    {
        return $query
            ->where(function($query) use ($home_location) {
                $query
                    ->where('based', self::BASED_ON_HOME_LOCATION)
                    ->whereHas('homeGovernmentalUnitArea', function ($query) use ($home_location) {
                        $query->atPoint($home_location[0], $home_location[1]);
                    });
            })
            ->orWhere(function($query) use ($work_location) {
                $query
                    ->where('based', self::BASED_ON_WORK_LOCATION)
                    ->whereHas('workGovernmentalUnitArea', function ($query) use ($work_location) {
                        $query->atPoint($work_location[0], $work_location[1]);
                    });
            })
            ->orWhere(function($query) use ($home_location, $work_location) {
                $query
                    ->where('based', self::BASED_ON_HOME_AND_NOT_WORK_LOCATION)
                    ->whereHas('homeGovernmentalUnitArea', function ($query) use ($home_location) {
                        $query->atPoint($home_location[0], $home_location[1]);
                    })
                    ->whereDoesntHave('workGovernmentalUnitArea', function ($query) use ($work_location) {
                        $query->atPoint($work_location[0], $work_location[1]);
                    });
            })
            ->orWhere(function($query) use ($home_location, $work_location) {
                $query
                    ->where('based', self::BASED_ON_WORK_AND_NOT_HOME_LOCATION)
                    ->whereDoesntHave('homeGovernmentalUnitArea', function ($query) use ($home_location) {
                        $query->atPoint($home_location[0], $home_location[1]);
                    })
                    ->whereHas('workGovernmentalUnitArea', function ($query) use ($work_location) {
                        $query->atPoint($work_location[0], $work_location[1]);
                    });
            })
            ->orWhere(function($query) use ($home_location, $work_location) {
                $query
                    ->where('based', self::BASED_ON_BOTH_LOCATIONS)
                    ->whereHas('homeGovernmentalUnitArea', function ($query) use ($home_location) {
                        $query->atPoint($home_location[0], $home_location[1]);
                    })
                    ->whereHas('workGovernmentalUnitArea', function ($query) use ($work_location) {
                        $query->atPoint($work_location[0], $work_location[1]);
                    });
            })
            ->orWhere(function($query) use ($home_location, $work_location) {
                $query
                    ->where('based', self::BASED_ON_EITHER_LOCATION)
                    ->where(function($query) use ($home_location, $work_location) {
                        $query
                            ->whereHas('homeGovernmentalUnitArea', function ($query) use ($home_location) {
                                $query->atPoint($home_location[0], $home_location[1]);
                            })
                            ->orWhereHas('workGovernmentalUnitArea', function ($query) use ($work_location) {
                                $query->atPoint($work_location[0], $work_location[1]);
                            });
                    });
            });
    }
}
