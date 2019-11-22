<?php

namespace Appleton\Taxes\Countries\US\Ohio\TwinValleyCommunityLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TwinValleyCommunityLSD\TwinValleyCommunityLSDTax as BaseTwinValleyCommunityLSDTax;

class TwinValleyCommunityLSDTax extends BaseTwinValleyCommunityLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
