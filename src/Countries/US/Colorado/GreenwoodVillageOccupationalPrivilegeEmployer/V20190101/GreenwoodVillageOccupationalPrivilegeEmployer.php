<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\GreenwoodVillageOccupationalPrivilegeEmployer as BaseGreenwoodVillageOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GreenwoodVillageOccupationalPrivilegeEmployer extends BaseGreenwoodVillageOccupationalPrivilegeEmployer
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
            ->where('name', 'Greenwood Village, CO')
            ->first();
    }
}
