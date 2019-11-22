<?php

namespace Appleton\Taxes\Countries\US\Ohio\MiamiEastLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MiamiEastLSD\MiamiEastLSDTax as BaseMiamiEastLSDTax;

class MiamiEastLSDTax extends BaseMiamiEastLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
