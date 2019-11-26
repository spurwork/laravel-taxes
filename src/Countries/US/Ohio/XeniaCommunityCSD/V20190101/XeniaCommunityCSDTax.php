<?php

namespace Appleton\Taxes\Countries\US\Ohio\XeniaCommunityCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\XeniaCommunityCSD\XeniaCommunityCSDTax as BaseXeniaCommunityCSDTax;

class XeniaCommunityCSDTax extends BaseXeniaCommunityCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
