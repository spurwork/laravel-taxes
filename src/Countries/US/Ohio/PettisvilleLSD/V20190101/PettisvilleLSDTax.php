<?php

namespace Appleton\Taxes\Countries\US\Ohio\PettisvilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PettisvilleLSD\PettisvilleLSDTax as BasePettisvilleLSDTax;

class PettisvilleLSDTax extends BasePettisvilleLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
