<?php

namespace Appleton\Taxes\Countries\US\Kentucky\FlorenceCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\FlorenceCity\FlorenceCity as BaseFlorenceCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class FlorenceCity extends BaseFlorenceCity
{
    use HasWageBase;

    const TAX_RATE = 0.02;
    const WAGE_BASE = 132900;

    private $governmental_unit_area;

    public function compute(Collection $tax_areas)
    {
        $this->governmental_unit_area = $tax_areas->first()->workGovernmentalUnitArea;

        return parent::compute($tax_areas);
    }

    public function getEarnings()
    {
        return $this->getBaseEarnings($this->governmental_unit_area);
    }
}
