<?php

namespace Appleton\Taxes\Countries\US\Medicare\V20170101;

use Illuminate\Database\Eloquent\Collection;

class MedicareEmployer extends Medicare
{
    const WITHHELD = false;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->getEarnings() * static::TAX_RATE, 2);
    }
}
