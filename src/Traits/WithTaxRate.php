<?php

namespace Appleton\Taxes\Traits;

trait WithTaxRate
{
    private $taxRate;

    private function taxRate()
    {
        return $this->taxRate;
    }

    public function withTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
        return $this;
    }
}
