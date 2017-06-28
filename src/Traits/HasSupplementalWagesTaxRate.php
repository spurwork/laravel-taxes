<?php

namespace Appleton\Taxes\Traits;

trait HasSupplementalWagesTaxRate
{
    private function getSupplementalWagesTaxRate()
    {
        return self::SUPPLEMENTAL_WAGES_TAX_RATE;
    }

    public function getSupplementalWagesTax()
    {
        return $this->supplementalWages() * $this->getSupplementalWagesTaxRate();
    }
}
