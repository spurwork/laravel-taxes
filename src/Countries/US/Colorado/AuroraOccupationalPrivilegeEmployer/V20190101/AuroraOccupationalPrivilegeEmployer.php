<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\V20190101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\AuroraOccupationalPrivilegeEmployer as BaseAuroraOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class AuroraOccupationalPrivilegeEmployer extends BaseAuroraOccupationalPrivilegeEmployer
{
    private const MONTHLY_WAGE_AMOUNT = 25000;
    private const MONTHLY_TAX_AMOUNT = 200;

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
            ->where('name', 'Aurora, CO')
            ->first();
    }
}
