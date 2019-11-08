<?php

namespace Appleton\Taxes\Countries\US\Ohio\SpencervilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SpencervilleLSD\SpencervilleLSDTax as BaseSpencervilleLSDTax;

class SpencervilleLSDTax extends BaseSpencervilleLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
