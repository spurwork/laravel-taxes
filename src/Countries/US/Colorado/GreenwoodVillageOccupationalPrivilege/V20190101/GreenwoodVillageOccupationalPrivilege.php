<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\GreenwoodVillageOccupationalPrivilege as BaseGreenwoodVillageOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GreenwoodVillageOccupationalPrivilege extends BaseGreenwoodVillageOccupationalPrivilege
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
