<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\GlendaleOccupationalPrivilege as BaseGlendaleOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GlendaleOccupationalPrivilege extends BaseGlendaleOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 75000;
    private const MONTHLY_TAX_AMOUNT = 500;

    public function getMonthlyWageAmount(): int
    {
        return self::MONTHLY_WAGE_AMOUNT;
    }

    public function getMonthlyTaxAmount(): int
    {
        return self::MONTHLY_TAX_AMOUNT;
    }

    protected function getLocalGovernmentalUnitArea(): GovernmentalUnitArea
    {
        return GovernmentalUnitArea::query()
            ->where('name', 'Glendale, CO')
            ->first();
    }
}
