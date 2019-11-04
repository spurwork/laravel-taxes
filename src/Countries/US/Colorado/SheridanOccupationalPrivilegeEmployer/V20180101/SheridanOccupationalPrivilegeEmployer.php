<?php

namespace Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\SheridanOccupationalPrivilegeEmployer\SheridanOccupationalPrivilegeEmployer as BaseDenverOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class SheridanOccupationalPrivilegeEmployer extends BaseDenverOccupationalPrivilegeEmployer
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
