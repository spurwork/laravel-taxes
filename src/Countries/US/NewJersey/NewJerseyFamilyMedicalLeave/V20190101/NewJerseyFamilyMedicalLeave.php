<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave\NewJerseyFamilyMedicalLeave as BaseNewJerseyFamilyMedicalLeave;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyFamilyMedicalLeave extends BaseNewJerseyFamilyMedicalLeave
{
    use HasWageBase;

    const TAX_RATE = 0.0008;
    const WAGE_BASE = 34400;

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
