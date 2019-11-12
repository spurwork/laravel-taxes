<?php

namespace Appleton\Taxes\Countries\US\Ohio\WapakonetaCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WapakonetaCSD\WapakonetaCSDTax as BaseWapakonetaCSDTax;

class WapakonetaCSDTax extends BaseWapakonetaCSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
