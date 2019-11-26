<?php

namespace Appleton\Taxes\Countries\US\Ohio\BowlingGreenCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BowlingGreenCSD\BowlingGreenCSDTax as BaseBowlingGreenCSDTax;

class BowlingGreenCSDTax extends BaseBowlingGreenCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
