<?php

namespace Appleton\Taxes\Countries\US\Ohio\MontpelierEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MontpelierEVSD\MontpelierEVSDTax as BaseMontpelierEVSDTax;

class MontpelierEVSDTax extends BaseMontpelierEVSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
