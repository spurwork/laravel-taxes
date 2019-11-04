<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\GreenwoodVillageOccupationalPrivilege as BaseGreenwoodVillageOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GreenwoodVillageOccupationalPrivilege extends BaseGreenwoodVillageOccupationalPrivilege
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
            ->where('name', 'Greenwood Village, CO')
            ->first();
    }
}
