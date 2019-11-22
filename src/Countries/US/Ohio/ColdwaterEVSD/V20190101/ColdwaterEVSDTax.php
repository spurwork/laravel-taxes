<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColdwaterEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ColdwaterEVSD\ColdwaterEVSDTax as BaseColdwaterEVSDTax;

class ColdwaterEVSDTax extends BaseColdwaterEVSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
