<?php

namespace Appleton\Taxes\Countries\US\Ohio\PrebleShawneeLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PrebleShawneeLSD\PrebleShawneeLSDTax as BasePrebleShawneeLSDTax;

class PrebleShawneeLSDTax extends BasePrebleShawneeLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
