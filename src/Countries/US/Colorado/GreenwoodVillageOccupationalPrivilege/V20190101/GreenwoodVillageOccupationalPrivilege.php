<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\GreenwoodVillageOccupationalPrivilege as BaseGreenwoodVillageOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class GreenwoodVillageOccupationalPrivilege extends BaseGreenwoodVillageOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 250;
    private const MONTHLY_TAX_AMOUNT = 200;

    protected function getMonthlyWageAmount(): int
    {
        return self::MONTHLY_WAGE_AMOUNT;
    }

    protected function getMonthlyTaxAmount(): int
    {
        return self::MONTHLY_TAX_AMOUNT;
    }

    protected function getLocalGovernmentalUnitArea(): stdClass
    {
        return DB::table('governmental_unit_areas')
            ->where('name', 'Greenwood Village, CO')
            ->first();
    }
}
