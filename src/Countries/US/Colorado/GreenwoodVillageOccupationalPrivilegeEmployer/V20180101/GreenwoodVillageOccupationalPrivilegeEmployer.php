<?php

namespace Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\GreenwoodVillageOccupationalPrivilegeEmployer as BaseGreenwoodVillageOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GreenwoodVillageOccupationalPrivilegeEmployer extends BaseGreenwoodVillageOccupationalPrivilegeEmployer
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
