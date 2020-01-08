<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorwalkCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorwalkCSD\NorwalkCSDTax as BaseNorwalkCSDTax;

class NorwalkCSDTax extends BaseNorwalkCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
