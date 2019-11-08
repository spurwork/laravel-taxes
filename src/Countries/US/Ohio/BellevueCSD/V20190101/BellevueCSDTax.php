<?php

namespace Appleton\Taxes\Countries\US\Ohio\BellevueCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BellevueCSD\BellevueCSDTax as BaseBellevueCSDTax;

class BellevueCSDTax extends BaseBellevueCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
