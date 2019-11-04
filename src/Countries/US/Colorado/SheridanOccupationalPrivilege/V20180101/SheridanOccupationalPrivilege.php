<?php

namespace Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilege\SheridanOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class SheridanOccupationalPrivilege extends BaseDenverOccupationalPrivilege
{
    public function getMonthlyWageAmount(): int
    {
        return 0;
    }

    public function getMonthlyTaxAmount(): int
    {
        return 0;
    }

    protected function getLocalGovernmentalUnitArea(): GovernmentalUnitArea
    {
        return GovernmentalUnitArea::query()
            ->where('name', 'Sheridan, CO')
            ->first();
    }
}
