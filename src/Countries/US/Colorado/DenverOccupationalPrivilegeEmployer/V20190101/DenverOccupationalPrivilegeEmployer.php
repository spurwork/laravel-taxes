<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\DenverOccupationalPrivilegeEmployer as BaseDenverOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class DenverOccupationalPrivilegeEmployer extends BaseDenverOccupationalPrivilegeEmployer
{
    private const MONTHLY_WAGE_AMOUNT = 50000;
    private const MONTHLY_TAX_AMOUNT = 400;

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
            ->where('name', 'Denver, CO')
            ->first();
    }
}
