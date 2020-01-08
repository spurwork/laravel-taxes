<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewarkCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewarkCSD\NewarkCSDTax as BaseNewarkCSDTax;

class NewarkCSDTax extends BaseNewarkCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
