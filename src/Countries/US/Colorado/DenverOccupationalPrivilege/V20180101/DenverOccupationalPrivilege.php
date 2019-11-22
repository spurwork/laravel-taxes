<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege as BaseDenverOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class DenverOccupationalPrivilege extends BaseDenverOccupationalPrivilege
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
            ->where('name', 'Denver, CO')
            ->first();
    }
}
