<?php

namespace Appleton\Taxes\Countries\US\Ohio\MinsterLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MinsterLSD\MinsterLSDTax as BaseMinsterLSDTax;
use Illuminate\Database\Eloquent\Collection;

class MinsterLSDTax extends BaseMinsterLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '0601';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round((($this->getGrossEarnings() - $this->getDependentAllowance()) * self::TAX_RATE) / $this->payroll->pay_periods, 2);
    }

    public function getDependentAllowance()
    {
        return $this->tax_information->dependents * 650;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods;
    }
}
