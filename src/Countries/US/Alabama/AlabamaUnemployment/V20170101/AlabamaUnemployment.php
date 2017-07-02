<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\V20170101;

use Appleton\Taxes\Classes\BaseStateUnemploymentTax;
use Appleton\Taxes\Traits\HasWageBase;

class AlabamaUnemployment extends BaseStateUnemploymentTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = false;

    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 8000;

    public function __construct($earnings = 0, $ytd_earnings = 0, $tax_rate = null)
    {
        $this->earnings = $earnings;
        $this->tax_rate = is_null($tax_rate) ? config('taxes.rates.us.alabama.unemployment', self::NEW_EMPLOYER_RATE) : $tax_rate;
        $this->ytd_earnings = $ytd_earnings;
    }

    private function getAdjustedEarnings()
    {
        return $this->earnings < $this->getBaseEarnings() ? $this->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
