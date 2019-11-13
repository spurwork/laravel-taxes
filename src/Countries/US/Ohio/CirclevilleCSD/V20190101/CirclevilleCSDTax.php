<?php

namespace Appleton\Taxes\Countries\US\Ohio\CirclevilleCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CirclevilleCSD\CirclevilleCSDTax as BaseCirclevilleCSDTax;

class CirclevilleCSDTax extends BaseCirclevilleCSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
