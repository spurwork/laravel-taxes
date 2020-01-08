<?php

namespace Appleton\Taxes\Countries\US\Ohio\WillardCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WillardCSD\WillardCSDTax as BaseWillardCSDTax;

class WillardCSDTax extends BaseWillardCSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
