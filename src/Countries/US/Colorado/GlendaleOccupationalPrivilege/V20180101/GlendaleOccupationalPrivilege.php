<?php

namespace Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\V20180101;

use Appleton\Taxes\Countries\US\Colorado\GlendaleOccupationalPrivilege\GlendaleOccupationalPrivilege as BaseGlendaleOccupationalPrivilege;
use Appleton\Taxes\Models\GovernmentalUnitArea;

class GlendaleOccupationalPrivilege extends BaseGlendaleOccupationalPrivilege
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
