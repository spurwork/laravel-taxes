<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PhiladelphiaLocalEITTax\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PhiladelphiaLocalEITTax\PhiladelphiaLocalEITTax as BasePhiladelphiaLocalEITTax;

use Illuminate\Database\Eloquent\Collection;

class PhiladelphiaLocalEITTax extends BasePhiladelphiaLocalEITTax
{
    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt_from_lst) {
            return 0.0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * $this->getEit());

        return round($this->tax_total, 2);
    }

    public function getEit()
    {
        if ($this->tax_information->resident_psd_code !== '510101' && $this->tax_information->employer_psd_code === '510101') {
            return $this->tax_information->employer_eit_rate / 100;
        } elseif ($this->tax_information->resident_psd_code === '510101') {
            return $this->tax_information->resident_eit_rate / 100;
        }
    }
}
