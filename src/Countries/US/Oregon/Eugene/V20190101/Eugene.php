<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene as BaseEugene;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class Eugene extends BaseEugene
{
    // public function compute(Collection $tax_areas)
    // {
    //     return 0.0;
    // }

    // this and below needs to be removed and the commented section above needs to uncommented

    const TAX_RATE_BETWEEN = 0.003;
    const TAX_RATE_OVER = 0.0044;
    const MIN_WAGE = 11.25;
    const HOURLY_WAGE_CAP = 15.0;

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
