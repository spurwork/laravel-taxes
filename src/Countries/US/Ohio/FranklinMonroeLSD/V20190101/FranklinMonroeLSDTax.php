<?php

namespace Appleton\Taxes\Countries\US\Ohio\FranklinMonroeLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FranklinMonroeLSD\FranklinMonroeLSDTax as BaseFranklinMonroeLSDTax;

class FranklinMonroeLSDTax extends BaseFranklinMonroeLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
