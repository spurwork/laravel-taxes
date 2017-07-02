<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;

class Medicare extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = true;

    const TAX_RATE = 0.0145;

    const ADDITIONAL_TAX_AMOUNT = 200000;
    const ADDITIONAL_TAX_RATE = 0.009;

    public function __construct($earnings, $ytd_earnings = 0)
    {
        $this->earnings = $earnings;
        $this->ytd_earnings = $ytd_earnings;
    }

    public function getAdditionalTaxAmount()
    {
        if ($this->ytd_earnings >= self::ADDITIONAL_TAX_AMOUNT) {
            return ($this->earnings - ($this->ytd_earnings - self::ADDITIONAL_TAX_AMOUNT)) * self::ADDITIONAL_TAX_RATE;
        } else {
            return 0;
        }
    }

    public function compute()
    {
        return round($this->earnings * self::TAX_RATE + $this->getAdditionalTaxAmount(), 2);
    }
}
