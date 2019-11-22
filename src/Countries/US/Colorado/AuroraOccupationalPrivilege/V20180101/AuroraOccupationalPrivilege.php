<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilege\AuroraOccupationalPrivilege as BaseAuroraOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class AuroraOccupationalPrivilege extends BaseAuroraOccupationalPrivilege
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
            ->where('name', 'Aurora, CO')
            ->first();
    }
}
