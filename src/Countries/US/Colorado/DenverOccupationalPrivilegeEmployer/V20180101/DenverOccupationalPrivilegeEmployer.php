<?php

namespace Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilegeEmployer\DenverOccupationalPrivilegeEmployer as BaseDenverOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class DenverOccupationalPrivilegeEmployer extends BaseDenverOccupationalPrivilegeEmployer
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
