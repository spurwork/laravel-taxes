<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class BirminghamOccupational extends BaseTax
{
    const TAX_RATE = 0.01;

    public function compute()
    {
        return round($this->earnings() * self::TAX_RATE, 2);
    }
}
