<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLocalEitTax\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLocalEITTax\PennsylvaniaLocalEITTax as BasePennsylvaniaLocalEITTax;

use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaLocalEITTax extends BasePennsylvaniaLocalEITTax
{
    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * $this->getEit());

        return round($this->tax_total, 2);
    }

    public function getEit()
    {
        return max($this->tax_information->resident_eit / 100, $this->tax_information->non_resident_eit / 100);
    }
}
