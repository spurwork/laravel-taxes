<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArcanumButlerLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ArcanumButlerLSD\ArcanumButlerLSDTax as BaseArcanumButlerLSDTax;

class ArcanumButlerLSDTax extends BaseArcanumButlerLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
