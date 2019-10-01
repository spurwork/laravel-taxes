<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class DenverOccupationalPrivilege extends BaseDenverOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 500;
    private const MONTHLY_TAX_AMOUNT = 575;

    protected function getMonthlyWageAmountInDollars(): int
    {
        return self::MONTHLY_WAGE_AMOUNT;
    }

    protected function getMonthlyTaxAmountInCents(): int
    {
        return self::MONTHLY_TAX_AMOUNT;
    }

    protected function getLocalGovernmentalUnitArea(): stdClass
    {
        return DB::table('governmental_unit_areas')
            ->where('name', 'Denver, CO')
            ->first();
    }
}
