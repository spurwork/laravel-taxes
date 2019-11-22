<?php

namespace Appleton\Taxes\Countries\US\Ohio\MiltonUnionEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MiltonUnionEVSD\MiltonUnionEVSDTax as BaseMiltonUnionEVSDTax;

class MiltonUnionEVSDTax extends BaseMiltonUnionEVSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
