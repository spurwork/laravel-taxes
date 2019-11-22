<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyUnionThurstonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LibertyUnionThurstonLSD\LibertyUnionThurstonLSDTax as BaseLibertyUnionThurstonLSDTax;

class LibertyUnionThurstonLSDTax extends BaseLibertyUnionThurstonLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
