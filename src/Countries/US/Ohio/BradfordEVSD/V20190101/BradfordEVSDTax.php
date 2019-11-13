<?php

namespace Appleton\Taxes\Countries\US\Ohio\BradfordEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BradfordEVSD\BradfordEVSDTax as BaseBradfordEVSDTax;

class BradfordEVSDTax extends BaseBradfordEVSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
