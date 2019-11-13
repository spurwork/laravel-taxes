<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorwayneLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorwayneLSD\NorwayneLSDTax as BaseNorwayneLSDTax;

class NorwayneLSDTax extends BaseNorwayneLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
