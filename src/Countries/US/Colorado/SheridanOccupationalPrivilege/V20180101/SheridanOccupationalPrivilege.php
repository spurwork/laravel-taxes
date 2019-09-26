<?php

namespace Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\SheridanOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class SheridanOccupationalPrivilege extends BaseDenverOccupationalPrivilege
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
