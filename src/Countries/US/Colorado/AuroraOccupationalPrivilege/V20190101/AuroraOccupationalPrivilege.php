<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\AuroraOccupationalPrivilege as BaseAuroraOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuroraOccupationalPrivilege extends BaseAuroraOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 25000;
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
            ->where('name', 'Aurora, CO')
            ->first();
    }
}
