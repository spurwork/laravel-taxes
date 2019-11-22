<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerkshireLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BerkshireLSD\BerkshireLSDTax as BaseBerkshireLSDTax;

class BerkshireLSDTax extends BaseBerkshireLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
