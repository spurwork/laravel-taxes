<?php

namespace Appleton\Taxes\Countries\US\Ohio\Akron\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Akron\Akron as BaseAkron;
use Illuminate\Database\Eloquent\Collection;

class Akron extends BaseAkron
{
    public const TAX_RATE = 0.025;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
