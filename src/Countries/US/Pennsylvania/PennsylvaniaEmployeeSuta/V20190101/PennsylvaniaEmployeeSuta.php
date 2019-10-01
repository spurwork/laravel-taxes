<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta\V20190101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta\PennsylvaniaEmployeeSuta as BasePennsylvaniaEmployeeSuta;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaEmployeeSuta extends BasePennsylvaniaEmployeeSuta
{
    const TAX_RATE = 0.0006;
    const WAGE_BASE = 1000000000;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax($this->payroll->getEarnings() * self::TAX_RATE), 2);
    }
}
