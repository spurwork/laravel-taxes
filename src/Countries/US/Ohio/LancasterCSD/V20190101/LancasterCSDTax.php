<?php

namespace Appleton\Taxes\Countries\US\Ohio\LancasterCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LancasterCSD\LancasterCSDTax as BaseLancasterCSDTax;

class LancasterCSDTax extends BaseLancasterCSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
