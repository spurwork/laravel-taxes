<?php

namespace Appleton\Taxes\Countries\US\Ohio\Cincinnati\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati as BaseCincinnati;
use Illuminate\Database\Eloquent\Collection;

class Cincinnati extends BaseCincinnati
{
    public const TAX_RATE = 0.021;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
