<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColumbianaEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ColumbianaEVSD\ColumbianaEVSDTax as BaseColumbianaEVSDTax;

class ColumbianaEVSDTax extends BaseColumbianaEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
