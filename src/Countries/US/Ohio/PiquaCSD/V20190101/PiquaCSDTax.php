<?php

namespace Appleton\Taxes\Countries\US\Ohio\PiquaCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PiquaCSD\PiquaCSDTax as BasePiquaCSDTax;

class PiquaCSDTax extends BasePiquaCSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
