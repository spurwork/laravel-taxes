<?php

namespace Appleton\Taxes\Countries\US\Ohio\BryanCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BryanCSD\BryanCSDTax as BaseBryanCSDTax;

class BryanCSDTax extends BaseBryanCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
