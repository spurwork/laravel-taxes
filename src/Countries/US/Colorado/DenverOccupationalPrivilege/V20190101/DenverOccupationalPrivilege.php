<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class DenverOccupationalPrivilege extends BaseDenverOccupationalPrivilege
{
    private const MONTHLY_WAGE_AMOUNT = 50000;
    private const MONTHLY_TAX_AMOUNT = 575;
    private const TAX_CLASS = BaseDenverOccupationalPrivilege::class;

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

    protected function getTaxClass(): string
    {
        return self::TAX_CLASS;
    }
}
