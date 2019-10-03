<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\GlendaleOccupationalPrivilege as BaseGlendaleOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class GlendaleOccupationalPrivilege extends BaseGlendaleOccupationalPrivilege
{
    protected function getMonthlyWageAmount(): int
    {
        return 0;
    }

    protected function getMonthlyTaxAmount(): int
    {
        return 0;
    }

    protected function getLocalGovernmentalUnitArea(): stdClass
    {
        return DB::table('governmental_unit_areas')
            ->where('name', 'Glendale, CO')
            ->first();
    }
}
