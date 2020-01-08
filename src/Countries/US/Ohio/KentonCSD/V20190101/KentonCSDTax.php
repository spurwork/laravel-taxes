<?php

namespace Appleton\Taxes\Countries\US\Ohio\KentonCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\KentonCSD\KentonCSDTax as BaseKentonCSDTax;

class KentonCSDTax extends BaseKentonCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
