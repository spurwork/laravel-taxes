<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairbornCSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairbornCSDTax\FairbornCSDTax as BaseFairbornCSDTax;
use Illuminate\Database\Eloquent\Collection;

class FairbornCSDTax extends BaseFairbornCSDTax
{
    public const TAX_RATE = 0.005;
    const ID = '2903';

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
