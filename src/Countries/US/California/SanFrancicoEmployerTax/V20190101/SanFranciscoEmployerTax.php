<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoEmployerTax\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoEmployerTax\SanFranciscoEmployerTax as BaseSanFranciscoEmployerTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class SanFranciscoEmployerTax extends BaseSanFranciscoEmployerTax
{
    const TOTAL_GROSS_PAYROLL = 300000;
    const TAX_RATE = 0.0038;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) > self::TOTAL_GROSS_PAYROLL) {
            return round($this->payroll->withholdTax($this->payroll->getEarnings() * self::TAX_RATE), 2);
        }
    }
}
