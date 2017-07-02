<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Classes\BaseStateUnemploymentTax;
use Appleton\Taxes\Traits\HasWageBase;

class FederalUnemployment extends BaseTax
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = false;

    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct($earnings, BaseStateUnemploymentTax $state_unemployment = null, $ytd_earnings = 0)
    {
        $this->earnings = $earnings;
        $this->tax_rate = is_null($state_unemployment) ? self::TAX_RATE : self::TAX_RATE - $state_unemployment->getUnemploymentTaxCredit();
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
