<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave\NewJerseyFamilyMedicalLeave as BaseNewJerseyFamilyMedicalLeave;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyFamilyMedicalLeave extends BaseNewJerseyFamilyMedicalLeave
{
    const TAX_RATE = 0.0017;
    const WAGE_BASE = 34400;

    public function getBaseEarnings()
    {
        dump('herer1');
        return max(min(static::WAGE_BASE - $this->payroll->wtd_earnings, $this->payroll->getEarnings()), 0);
    }

    public function compute(Collection $tax_areas)
    {
        dump('herer');
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
