<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;

class Medicare extends BaseTax
{
    const TAX_RATE = 0.0145;

    const ADDITIONAL_TAX_AMOUNT = 200000;
    const ADDITIONAL_TAX_RATE = 0.009;

    private function hasAddtionalTax()
    {
        return $this->ytdEarnings() >= self::ADDITIONAL_TAX_AMOUNT;
    }

    private function getAdditionalEarnings()
    {
        return $this->earnings() - ($this->ytdEarnings() - self::ADDITIONAL_TAX_AMOUNT);
    }

    private function getAdditionalTaxAmount()
    {
        return $this->hasAddtionalTax() ? $this->getAdditionalEarnings() * self::ADDITIONAL_TAX_RATE : 0;
    }

    public function compute()
    {
        return round($this->earnings() * self::TAX_RATE + $this->getAdditionalTaxAmount(), 2);
    }
}
