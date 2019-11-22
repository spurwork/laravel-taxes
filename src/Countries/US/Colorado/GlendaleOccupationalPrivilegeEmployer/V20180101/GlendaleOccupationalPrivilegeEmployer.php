<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilegeEmployer\GlendaleOccupationalPrivilegeEmployer as BaseGlendaleOccupationalPrivilegeEmployer;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GlendaleOccupationalPrivilegeEmployer extends BaseGlendaleOccupationalPrivilegeEmployer
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
            ->where('name', 'Glendale, CO')
            ->first();
    }
}
