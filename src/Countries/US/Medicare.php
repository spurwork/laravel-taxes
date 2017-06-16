<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\WithYtdEarnings;

class Medicare extends BaseTax
{
    use WithYtdEarnings;

    const TYPE = 'federal';
    const WITHHELD = true;

    const TAX_RATE = 0.0145;

    const ADDITIONAL_TAX_AMOUNT = 200000;
    const ADDITIONAL_TAX_RATE = 0.009;

    private function hasAdditionalTax()
    {
        return $this->ytdEarnings() >= self::ADDITIONAL_TAX_AMOUNT;
    }

    private function getAdditionalEarnings()
    {
        return $this->earnings() - ($this->ytdEarnings() - self::ADDITIONAL_TAX_AMOUNT);
    }

    private function getAdditionalTaxAmount()
    {
        return $this->hasAdditionalTax() ? $this->getAdditionalEarnings() * self::ADDITIONAL_TAX_RATE : 0;
    }

    public function compute()
    {
        return round($this->earnings() * self::TAX_RATE + $this->getAdditionalTaxAmount(), 2);
    }
}
