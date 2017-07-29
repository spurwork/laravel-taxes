<?php

namespace Appleton\Taxes\Countries\US\Medicare\V20170101;

use Appleton\Taxes\Countries\US\Medicare\Medicare as BaseMedicare;

class Medicare extends BaseMedicare
{
    const TAX_RATE = 0.0145;

    const ADDITIONAL_TAX_AMOUNT = 200000;
    const ADDITIONAL_TAX_RATE = 0.009;

    public function getAdditionalTaxAmount()
    {
        return max($this->payroll->earnings - max(static::ADDITIONAL_TAX_AMOUNT - $this->payroll->ytd_earnings, 0), 0) * static::ADDITIONAL_TAX_RATE;
    }

    public function compute()
    {
        return round($this->payroll->earnings * static::TAX_RATE + $this->getAdditionalTaxAmount(), 2);
    }
}
