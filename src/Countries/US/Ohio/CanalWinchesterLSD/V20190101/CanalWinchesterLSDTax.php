<?php

namespace Appleton\Taxes\Countries\US\Ohio\CanalWinchesterLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CanalWinchesterLSD\CanalWinchesterLSDTax as BaseCanalWinchesterLSDTax;

class CanalWinchesterLSDTax extends BaseCanalWinchesterLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
