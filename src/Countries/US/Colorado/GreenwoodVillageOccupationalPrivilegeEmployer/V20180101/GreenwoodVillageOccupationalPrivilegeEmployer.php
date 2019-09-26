<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\GreenwoodVillageOccupationalPrivilegeEmployer as BaseGreenwoodVillageOccupationalPrivilegeEmployer;
use Illuminate\Support\Facades\DB;
use stdClass;

class GreenwoodVillageOccupationalPrivilegeEmployer extends BaseGreenwoodVillageOccupationalPrivilegeEmployer
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
            ->where('name', 'Greenwood Village, CO')
            ->first();
    }
}
