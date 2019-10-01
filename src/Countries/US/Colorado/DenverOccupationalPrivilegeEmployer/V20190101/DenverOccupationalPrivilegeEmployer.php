<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\DenverOccupationalPrivilegeEmployer as BaseDenverOccupationalPrivilegeEmployer;
use Illuminate\Support\Facades\DB;
use stdClass;

class DenverOccupationalPrivilegeEmployer extends BaseDenverOccupationalPrivilegeEmployer
{
    private const MONTHLY_WAGE_AMOUNT = 500;
    private const MONTHLY_TAX_AMOUNT = 400;

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
