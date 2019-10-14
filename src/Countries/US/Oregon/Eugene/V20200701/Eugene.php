<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene\V20200701;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene as BaseEugene;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class Eugene extends BaseEugene
{
    const TAX_RATE_BETWEEN = 0.003;
    const TAX_RATE_OVER = 0.0044;
    const MIN_WAGE = 1125;
    const HOURLY_WAGE_CAP = 1500;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->getPayRate() <= self::MIN_WAGE) {
            return;
        } elseif ($this->payroll->getPayRate() > self::MIN_WAGE && $this->payroll->getPayRate() < self::HOURLY_WAGE_CAP) {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE_BETWEEN);
        } else {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE_OVER);
        }

        return round($this->tax_total, 2);
    }
}
