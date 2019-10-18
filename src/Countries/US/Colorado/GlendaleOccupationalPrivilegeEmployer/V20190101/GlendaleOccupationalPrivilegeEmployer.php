<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\GlendaleOccupationalPrivilegeEmployer as BaseGlendaleOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GlendaleOccupationalPrivilegeEmployer extends BaseGlendaleOccupationalPrivilegeEmployer
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
