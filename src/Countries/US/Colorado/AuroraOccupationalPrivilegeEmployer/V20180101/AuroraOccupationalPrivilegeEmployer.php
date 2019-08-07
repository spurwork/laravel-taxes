<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\AuroraOccupationalPrivilegeEmployer as BaseAuroraOccupationalPrivilegeEmployer;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuroraOccupationalPrivilegeEmployer extends BaseAuroraOccupationalPrivilegeEmployer
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
            ->where('name', 'Aurora, CO')
            ->first();
    }
}
