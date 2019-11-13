<?php

namespace Appleton\Taxes\Countries\US\Ohio\PauldingEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PauldingEVSD\PauldingEVSDTax as BasePauldingEVSDTax;

class PauldingEVSDTax extends BasePauldingEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
