<?php

namespace Appleton\Taxes\Countries\US\Ohio\FortLoramieLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FortLoramieLSD\FortLoramieLSDTax as BaseFortLoramieLSDTax;

class FortLoramieLSDTax extends BaseFortLoramieLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
