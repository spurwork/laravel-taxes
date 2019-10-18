<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\AuroraOccupationalPrivilege as BaseAuroraOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class AuroraOccupationalPrivilege extends BaseAuroraOccupationalPrivilege
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
