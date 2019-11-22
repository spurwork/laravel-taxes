<?php

namespace Appleton\Taxes\Countries\US\Ohio\FortRecoveryLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FortRecoveryLSD\FortRecoveryLSDTax as BaseFortRecoveryLSDTax;

class FortRecoveryLSDTax extends BaseFortRecoveryLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
