<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class FederalUnemployment extends BaseTax
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = false;

    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct($credit = 0, $earnings, $ytd_earnings = 0)
    {
        $this->credit = $credit;
        $this->earnings = $earnings;
        $this->tax_rate = is_null($credit) ?  self::TAX_RATE : self::TAX_RATE - $credit;
        $this->ytd_earnings = $ytd_earnings;
    }

    public function getAdjustedEarnings()
    {
        return $this->earnings < $this->getBaseEarnings() ? $this->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
