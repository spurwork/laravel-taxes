<?php

namespace Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilegeEmployer\SheridanOccupationalPrivilegeEmployer as BaseDenverOccupationalPrivilegeEmployer;
use Illuminate\Support\Facades\DB;
use stdClass;

class SheridanOccupationalPrivilegeEmployer extends BaseDenverOccupationalPrivilegeEmployer
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
            ->where('name', 'Sheridan, CO')
            ->first();
    }
}
