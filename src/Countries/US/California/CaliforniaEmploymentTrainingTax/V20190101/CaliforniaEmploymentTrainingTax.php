<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax\V20190101;

use Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax\CaliforniaEmploymentTrainingTax as BaseCaliforniaEmploymentTrainingTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CaliforniaEmploymentTrainingTax extends BaseCaliforniaEmploymentTrainingTax
{
    use HasWageBase;

    const TAX_RATE = 0.001;
    const WAGE_BASE = 7000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
