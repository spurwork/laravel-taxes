<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\GreenwoodVillageOccupationalPrivilege as BaseGreenwoodVillageOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class GreenwoodVillageOccupationalPrivilege extends BaseGreenwoodVillageOccupationalPrivilege
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
