<?php

namespace Appleton\Taxes\Countries\US\Ohio\ReynoldsburgCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ReynoldsburgCSD\ReynoldsburgCSDTax as BaseReynoldsburgCSDTax;

class ReynoldsburgCSDTax extends BaseReynoldsburgCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
