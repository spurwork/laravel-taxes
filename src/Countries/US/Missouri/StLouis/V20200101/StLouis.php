<?php

namespace Appleton\Taxes\Countries\US\Missouri\StLouis\V20200101;

use Appleton\Taxes\Countries\US\Missouri\StLouis\StLouis as BaseStLouis;

use Illuminate\Database\Eloquent\Collection;

class StLouis extends BaseStLouis
{
    const TAX_RATE = 0.01;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);

        return round($this->tax_total, 2);
    }
}
