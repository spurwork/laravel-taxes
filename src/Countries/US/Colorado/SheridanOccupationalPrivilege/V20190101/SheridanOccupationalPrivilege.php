<?php

namespace Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\SheridanOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class SheridanOccupationalPrivilege extends BaseDenverOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 50000;
    private const MONTHLY_TAX_AMOUNT = 300;

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
            ->where('name', 'Sheridan, CO')
            ->first();
    }
}
