<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene\V20200701;

use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene as BaseEugene;

use Illuminate\Database\Eloquent\Collection;

class Eugene extends BaseEugene
{
    const TAX_RATE_BETWEEN = 0.003;
    const TAX_RATE_OVER = 0.0044;
    const MIN_WAGE = 11.25;
    const HOURLY_WAGE_CAP = 15.00;

    public function compute(Collection $tax_areas)
    {
        $pay_rate = $this->payroll->getPayRate($tax_areas->first()->workGovernmentalUnitArea);

        if ($pay_rate <= self::MIN_WAGE) {
            return;
        } elseif ($pay_rate > self::MIN_WAGE && $pay_rate < self::HOURLY_WAGE_CAP) {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE_BETWEEN);
        } else {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE_OVER);
        }

        return round($this->tax_total, 2);
    }
}
