<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreenvilleCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GreenvilleCSD\GreenvilleCSDTax as BaseGreenvilleCSDTax;

class GreenvilleCSDTax extends BaseGreenvilleCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
