<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax\V20190101;

use Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax\CaliforniaEmploymentTrainingTax as BaseCaliforniaEmploymentTrainingTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CaliforniaEmploymentTrainingTax extends BaseCaliforniaEmploymentTrainingTax
{
    use HasWageBase;

    const TAX_RATE = 0.001;
    const WAGE_BASE = 7000;

    public function getBaseEarnings()
    {
        if (($this->payroll->earnings + $this->payroll->ytd_earnings + $this->payroll->wtd_earnings) < self::WAGE_BASE) {
            return max(min(static::WAGE_BASE - $this->payroll->ytd_earnings, $this->payroll->getEarnings()), 0);
        } elseif (($this->payroll->earnings + $this->payroll->ytd_earnings + $this->payroll->wtd_earnings) >= self::WAGE_BASE) {
            $total = self::WAGE_BASE - $this->payroll->ytd_earnings;

            return $total > 0 ? $total : 0;
        }

        return 0;
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
