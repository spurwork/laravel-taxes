<?php

namespace Appleton\Taxes\Countries\US\Ohio\FremontCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FremontCSD\FremontCSDTax as BaseFremontCSDTax;

class FremontCSDTax extends BaseFremontCSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
