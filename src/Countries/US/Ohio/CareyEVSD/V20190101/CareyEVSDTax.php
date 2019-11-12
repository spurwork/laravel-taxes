<?php

namespace Appleton\Taxes\Countries\US\Ohio\CareyEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CareyEVSD\CareyEVSDTax as BaseCareyEVSDTax;

class CareyEVSDTax extends BaseCareyEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
