<?php

namespace Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\AuroraOccupationalPrivilegeEmployer as BaseAuroraOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class AuroraOccupationalPrivilegeEmployer extends BaseAuroraOccupationalPrivilegeEmployer
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
