<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\GlendaleOccupationalPrivilege as BaseGlendaleOccupationalPrivilege;
use Illuminate\Support\Facades\DB;
use stdClass;

class GlendaleOccupationalPrivilege extends BaseGlendaleOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 750;
    private const MONTHLY_TAX_AMOUNT = 500;

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
            ->where('name', 'Glendale, CO')
            ->first();
    }
}
