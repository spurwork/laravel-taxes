<?php

namespace Appleton\Taxes\Traits;

trait HasTaxRate
{
    private function getTaxRate()
    {
        return self::TAX_RATE;
    }

    public function compute()
    {
        return round($this->earnings() * $this->getTaxRate(), 2);
    }
}
