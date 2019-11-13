<?php

namespace Appleton\Taxes\Countries\US\Ohio\MountGileadEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MountGileadEVSD\MountGileadEVSDTax as BaseMountGileadEVSDTax;

class MountGileadEVSDTax extends BaseMountGileadEVSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
