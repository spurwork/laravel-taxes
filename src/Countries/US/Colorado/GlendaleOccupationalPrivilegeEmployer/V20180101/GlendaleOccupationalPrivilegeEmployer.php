<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\GlendaleOccupationalPrivilegeEmployer as BaseGlendaleOccupationalPrivilegeEmployer;
use Illuminate\Support\Facades\DB;
use stdClass;

class GlendaleOccupationalPrivilegeEmployer extends BaseGlendaleOccupationalPrivilegeEmployer
{
    protected function getMonthlyWageAmountInDollars(): int
    {
        return 0;
    }

    protected function getMonthlyTaxAmountInCents(): int
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
