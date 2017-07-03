<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Classes\BaseStateUnemploymentTax;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment as BaseFederalUnemployment;
use Appleton\Taxes\Traits\HasWageBase;

class FederalUnemployment extends BaseFederalUnemployment
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = false;

    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct(BaseStateUnemploymentTax $state_unemployment)
    {
        $this->state_unemployment = $state_unemployment;
    }

    public function built()
    {
        $this->tax_rate = static::TAX_RATE - $this->state_unemployment->getUnemploymentTaxCredit();
        $this->wage_base = static::WAGE_BASE;
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
