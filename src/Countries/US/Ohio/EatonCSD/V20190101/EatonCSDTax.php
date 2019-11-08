<?php

namespace Appleton\Taxes\Countries\US\Ohio\EatonCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EatonCSD\EatonCSDTax as BaseEatonCSDTax;

class EatonCSDTax extends BaseEatonCSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
