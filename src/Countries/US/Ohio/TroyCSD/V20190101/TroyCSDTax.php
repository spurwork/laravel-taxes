<?php

namespace Appleton\Taxes\Countries\US\Ohio\TroyCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TroyCSD\TroyCSDTax as BaseTroyCSDTax;

class TroyCSDTax extends BaseTroyCSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
